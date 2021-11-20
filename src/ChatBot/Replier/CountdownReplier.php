<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Reply;
use App\ChatBot\Telegram\Data\Envelope;
use App\SymfonyCon\Timer;

class CountdownReplier implements ReplierInterface
{
    public function __construct(
        private Timer $timer,
    ) {
    }

    public function supports(Envelope $envelope): bool
    {
        return '/countdown' === $envelope->getMessage()->text;
    }

    public function reply(Envelope $envelope): Reply
    {
        $countdown = $this->timer->getCountdown();

        return new Reply(sprintf('%d days, %d hours and %d minutes', $countdown->d, $countdown->h, $countdown->i));
    }
}
