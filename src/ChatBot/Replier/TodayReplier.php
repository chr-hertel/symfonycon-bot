<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Reply\SlotReply;
use App\ChatBot\Telegram\Data\Envelope;
use App\SymfonyCon\Schedule;

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

    public function reply(Envelope $envelope): SlotReply
    {
        return new SlotReply($this->schedule->today());
    }
}
