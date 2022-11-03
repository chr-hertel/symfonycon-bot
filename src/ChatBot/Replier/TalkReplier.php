<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Telegram\Data\Update;
use App\Repository\TalkRepository;
use Keiko\Uuid\Shortener\Shortener;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\Button\InlineKeyboardButton;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\InlineKeyboardMarkup;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\Message\ChatMessage;
use Twig\Environment;

final class TalkReplier extends CommandReplier
{
    public function __construct(
        private readonly TalkRepository $repository,
        private readonly Shortener $shortener,
        private readonly Environment $twig,
    ) {
    }

    public function getCommand(): string
    {
        return 'talk';
    }

    public function registerCommand(): bool
    {
        return false;
    }

    public function reply(Update $update): ChatMessage
    {
        // remove "/talk@" from message text
        $shortId = substr($update->getText(), 6);
        $talk = $this->repository->findByShortId($shortId);

        if (null === $talk) {
            return new ChatMessage('Missing or invalid talk ID.');
        }

        $buttons = [];
        $buttons[] = (new InlineKeyboardButton('Attend'))
            ->callbackData('/attend@'.$this->shortener->reduce($talk->getId()));
        $buttons[] = (new InlineKeyboardButton('Rate Talk'))
            ->callbackData('/rate@'.$this->shortener->reduce($talk->getId()));

        return new ChatMessage(
            $this->twig->render('talk.html.twig', ['talk' => $talk]),
            (new TelegramOptions())->replyMarkup((new InlineKeyboardMarkup())->inlineKeyboard($buttons)),
        );
    }
}
