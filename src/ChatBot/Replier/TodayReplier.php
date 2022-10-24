<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Telegram\Data\Update;
use App\SymfonyCon\Schedule;
use Symfony\Component\Notifier\Message\ChatMessage;

final class TodayReplier extends CommandReplier
{
    public function __construct(private readonly Schedule $schedule)
    {
    }

    public function getCommand(): string
    {
        return 'today';
    }

    public function getDescription(): string
    {
        return 'Lists all talks of today';
    }

    public function reply(Update $update): ChatMessage
    {
        return new ChatMessage((string) $this->schedule->today());
    }
}
