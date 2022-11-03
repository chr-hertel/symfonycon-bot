<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Telegram\Data\Update;
use App\Entity\Attendance;
use App\Repository\TalkRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

final class AttendanceReplier extends CommandReplier
{
    public function __construct(
        private readonly TalkRepository $repository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function getCommand(): string
    {
        return 'attend';
    }

    public function registerCommand(): bool
    {
        return false;
    }

    public function reply(Update $update): ChatMessage
    {
        // remove "/attend@" from message text
        $shortId = substr($update->getText(), 8);
        $talk = $this->repository->findByShortId($shortId);

        if (null === $talk) {
            return new ChatMessage('Missing or invalid talk ID.');
        }

        try {
            $this->entityManager->persist(new Attendance($talk, $update->getChatId()));
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException) {
            return new ChatMessage('You are already attending!');
        }

        return new ChatMessage('Noted, have fun!');
    }
}
