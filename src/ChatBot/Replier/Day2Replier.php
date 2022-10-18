<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Reply;
use App\ChatBot\Telegram\Data\Envelope;
use App\SymfonyCon\Schedule;

class Day2Replier extends CommandReplier
{
    public function __construct(
        private readonly Schedule $schedule,
    ) {
    }

    public function getCommand(): string
    {
        return 'day2';
    }

    public function getDescription(): string
    {
        return 'Lists all talks of the second day';
    }

    public function reply(Envelope $envelope): Reply
    {
        return new Reply((string) $this->schedule->day2());
    }
}
