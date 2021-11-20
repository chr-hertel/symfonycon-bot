<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Reply;
use App\ChatBot\Telegram\Data\Envelope;
use App\SymfonyCon\Schedule;

class NextReplier implements ReplierInterface
{
    public function __construct(
        private Schedule $schedule,
    ) {
    }

    public function supports(Envelope $envelope): bool
    {
        return '/next' === $envelope->getMessage()->text;
    }

    public function reply(Envelope $envelope): Reply
    {
        return new Reply((string) $this->schedule->next());
    }
}
