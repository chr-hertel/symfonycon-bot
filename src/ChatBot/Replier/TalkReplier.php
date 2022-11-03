<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Telegram\Data\Update;
use App\Repository\TalkRepository;
use Symfony\Component\Notifier\Message\ChatMessage;
use Twig\Environment;

final class TalkReplier extends CommandReplier
{
    public function __construct(private readonly TalkRepository $repository, private readonly Environment $twig)
    {
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

        return new ChatMessage(
            $this->twig->render('talk.html.twig', ['talk' => $talk])
        );
    }
}
