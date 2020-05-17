<?php

declare(strict_types=1);

namespace App\ChatBot;

use App\ChatBot\Replier\ReplierInterface;
use App\ChatBot\Telegram\Data\Envelope;

class ReplyMachine
{
    /**
     * @var ReplierInterface[]
     */
    private iterable $repliers;

    /**
     * @param ReplierInterface[] $repliers
     */
    public function __construct(iterable $repliers)
    {
        $this->repliers = $repliers;
    }

    public function findReply(Envelope $envelope): Reply
    {
        foreach ($this->repliers as $replier) {
            if ($replier->supports($envelope)) {
                return $replier->reply($envelope);
            }
        }

        return new Reply('Sorry, I didn\'t get that! Please try /help instead!');
    }
}
