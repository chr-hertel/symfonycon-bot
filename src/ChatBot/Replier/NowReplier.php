<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Reply;
use App\ChatBot\Telegram\Data\Envelope;
use App\SymfonyCon\Schedule;

class NowReplier implements ReplierInterface
{
    private Schedule $schedule;

    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    public function supports(Envelope $envelope): bool
    {
        return '/now' === $envelope->getMessage()->text;
    }

    public function reply(Envelope $envelope): Reply
    {
        return new Reply((string) $this->schedule->now());
    }
}
