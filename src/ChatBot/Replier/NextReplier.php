<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Replier\Renderer\SlotRenderer;
use App\ChatBot\Telegram\Data\Update;
use App\SymfonyCon\Schedule;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\Message\ChatMessage;

final class NextReplier extends CommandReplier
{
    public function __construct(private readonly Schedule $schedule, private readonly SlotRenderer $renderer)
    {
    }

    public function getCommand(): string
    {
        return 'next';
    }

    public function getDescription(): string
    {
        return 'Lists all talks happening next slot';
    }

    public function reply(Update $update): ChatMessage
    {
        $slot = $this->schedule->next();

        if (null === $slot) {
            return new ChatMessage('<b>Next Slot</b>'.PHP_EOL.PHP_EOL.'<i>Nothing found.</i>');
        }

        return new ChatMessage(
            $this->renderer->render('Next Slot', $slot),
            (new TelegramOptions())->replyMarkup($this->renderer->buttons($slot)),
        );
    }
}
