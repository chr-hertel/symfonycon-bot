<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Reply;
use App\ChatBot\Telegram\Data\Envelope;
use App\SymfonyCon\Timer;

class CountdownReplier implements ReplierInterface
{
    private Timer $timer;

    public function __construct(Timer $timer)
    {
        $this->timer = $timer;
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
