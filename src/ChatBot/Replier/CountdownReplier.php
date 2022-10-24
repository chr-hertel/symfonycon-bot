<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Telegram\Data\Update;
use App\SymfonyCon\Timer;
use Symfony\Component\Notifier\Message\ChatMessage;

final class CountdownReplier extends CommandReplier
{
    public function __construct(private readonly Timer $timer)
    {
    }

    public function getCommand(): string
    {
        return 'countdown';
    }

    public function getDescription(): string
    {
        return 'Time until SymfonyCon starts';
    }

    public function reply(Update $update): ChatMessage
    {
        $countdown = $this->timer->getCountdown();
        $message = 'Only *%d days, %d hours and %d minutes* until SymfonyCon starts.';

        return new ChatMessage(
            sprintf($message, $countdown->d, $countdown->h, $countdown->i)
        );
    }
}
