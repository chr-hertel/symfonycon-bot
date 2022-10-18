<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Reply;
use App\ChatBot\Telegram\Data\Envelope;
use App\SymfonyCon\Timer;

class CountdownReplier extends CommandReplier
{
    public function __construct(
        private readonly Timer $timer,
    ) {
    }

    public function getCommand(): string
    {
        return 'countdown';
    }

    public function getDescription(): string
    {
        return 'Time until SymfonyCon starts';
    }

    public function reply(Envelope $envelope): Reply
    {
        $countdown = $this->timer->getCountdown();

        return new Reply(sprintf('%d days, %d hours and %d minutes', $countdown->d, $countdown->h, $countdown->i));
    }
}
