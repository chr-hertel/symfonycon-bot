<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Replier\Renderer\SlotRenderer;
use App\ChatBot\Telegram\Data\Update;
use App\SymfonyCon\Schedule;
use Symfony\Component\Notifier\Message\ChatMessage;

final class NowReplier extends CommandReplier
{
    public function __construct(private readonly Schedule $schedule, private readonly SlotRenderer $renderer)
    {
    }

    public function getCommand(): string
    {
        return 'now';
    }

    public function getDescription(): string
    {
        return 'Lists all talks happening right now';
    }

    public function reply(Update $update): ChatMessage
    {
        $slot = $this->schedule->now();

        if (null === $slot) {
            return new ChatMessage('<b>Current Slot</b>'.PHP_EOL.PHP_EOL.'<i>Nothing found.</i>');
        }

        return new ChatMessage($this->renderer->render('Current Slot', $slot));
    }
}
