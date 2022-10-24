<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Telegram\Data\Update;
use App\Repository\SlotRepository;
use Keiko\Uuid\Shortener\Shortener;
use Symfony\Component\Notifier\Message\ChatMessage;
use Twig\Environment;

final class SlotReplier extends CommandReplier
{
    public function __construct(
        private readonly Shortener $shortener,
        private readonly SlotRepository $repository,
        private readonly Environment $twig,
    ) {
    }

    public function getCommand(): string
    {
        return 'slot';
    }

    public function getDescription(): string
    {
        return '';
    }

    public function registerCommand(): bool
    {
        return false;
    }

    public function reply(Update $update): ChatMessage
    {
        // remove "/slot@" from message text
        $shortId = substr($update->getMessage()->text, 6);
        $uuid = $this->shortener->expand($shortId);
        $slot = $this->repository->find($uuid);

        if (null === $slot) {
            return new ChatMessage('Missing or invalid Slot ID.');
        }

        return new ChatMessage(
            $this->twig->render('slot.html.twig', ['slot' => $slot])
        );
    }
}
