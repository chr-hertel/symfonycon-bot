<?php

declare(strict_types=1);

namespace App\ChatBot;

use App\ChatBot\Replier\ReplierInterface;
use App\ChatBot\Telegram\Data\Update;
use Symfony\Component\Notifier\Message\ChatMessage;

final class ReplyMachine
{
    /**
     * @param iterable<ReplierInterface> $repliers
     */
    public function __construct(
        private readonly iterable $repliers,
    ) {
    }

    public function findReply(Update $update): ChatMessage
    {
        foreach ($this->repliers as $replier) {
            if ($replier->supports($update)) {
                return $replier->reply($update);
            }
        }

        return new ChatMessage('Sorry, I didn\'t get that! Please try /help instead!');
    }
}
