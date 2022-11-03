<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Telegram\Data\Update;
use App\Entity\AttendeeRating;
use App\Entity\Rating;
use App\Repository\TalkRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Keiko\Uuid\Shortener\Shortener;
use Symfony\Component\Clock\ClockInterface;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\Button\InlineKeyboardButton;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\InlineKeyboardMarkup;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\Message\ChatMessage;

final class RatingReplier extends CommandReplier
{
    public const LABEL = [
        1 => '⭐',
        2 => '⭐⭐',
        3 => '⭐⭐⭐',
    ];

    public function __construct(
        private readonly TalkRepository $repository,
        private readonly ClockInterface $clock,
        private readonly Shortener $shortener,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function getCommand(): string
    {
        return 'rate';
    }

    public function registerCommand(): bool
    {
        return false;
    }

    public function reply(Update $update): ChatMessage
    {
        // remove "/rate@" from message text
        $payload = substr($update->getText(), 6);
        $hasRating = str_contains($payload, '=');

        $shortId = substr($payload, 0, $hasRating ? -2 : null);
        $rating = $hasRating ? substr($payload, -1) : null;

        dump($shortId, $rating);

        $talk = $this->repository->findByShortId($shortId);

        if (null === $talk) {
            return new ChatMessage('Missing or invalid talk ID.');
        }

        if (!$talk->isOver($this->clock->now())) {
            return new ChatMessage('You cannot rate a talk before it\'s over.');
        }

        if (null === $rating) {
            $buttons = array_map(function (int $rating) use ($talk) {
                return (new InlineKeyboardButton(self::LABEL[$rating]))->callbackData(sprintf(
                    '/rate@%s=%d', $this->shortener->reduce($talk->getId()), $rating
                ));
            }, array_keys(self::LABEL));
            $options = (new TelegramOptions())
                ->replyMarkup((new InlineKeyboardMarkup())->inlineKeyboard($buttons));

            return new ChatMessage('Please enter a rating for "<b>'.$talk->getTitle().'</b>"', $options);
        }

        try {
            $this->entityManager->persist(new AttendeeRating($talk, $update->getChatId(), Rating::from((int) $rating)));
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException) {
            return new ChatMessage('You already rated this talk!');
        }

        return new ChatMessage('Thanks for your rating!');
    }
}
