<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Reply;
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

    public function reply(Envelope $envelope): Reply
    {
        return new Reply((string) $this->schedule->today());
    }
}
