<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Replier\Renderer\SlotRenderer;
use App\ChatBot\Telegram\Data\Update;
use App\Repository\SlotRepository;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\Message\ChatMessage;

final class SlotReplier extends CommandReplier
{
    public function __construct(private readonly SlotRepository $repository, private readonly SlotRenderer $renderer)
    {
    }

    public function getCommand(): string
    {
        return 'slot';
    }

    public function registerCommand(): bool
    {
        return false;
    }

    public function reply(Update $update): ChatMessage
    {
        // remove "/slot@" from message text
        $shortId = substr($update->getText(), 6);
        $slot = $this->repository->findByShortId($shortId);

        if (null === $slot) {
            return new ChatMessage('Missing or invalid Slot ID.');
        }

        return new ChatMessage(
            $this->renderer->render('Next Slot', $slot),
            (new TelegramOptions())
                ->replyMarkup($this->renderer->buttons($slot))
                // update previously send message instead of new one
                ->edit($update->getMessage()->messageId),
        );
    }
}
