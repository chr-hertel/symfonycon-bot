<?php

declare(strict_types=1);

namespace App\ChatBot;

use App\ChatBot\Replier\ReplierInterface;
use App\ChatBot\Reply\Reply;
use App\ChatBot\Reply\TextReply;
use App\ChatBot\Telegram\Data\Envelope;

final class ReplyMachine
{
    /**
     * @param iterable<ReplierInterface> $repliers
     */
    public function __construct(
        private readonly iterable $repliers,
    ) {
    }

    public function findReply(Envelope $envelope): Reply
    {
        foreach ($this->repliers as $replier) {
            if ($replier->supports($envelope)) {
                return $replier->reply($envelope);
            }
        }

        return new TextReply('Sorry, I didn\'t get that! Please try /help instead!');
    }
}
