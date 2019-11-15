<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Reply;
use App\ChatBot\Telegram\Data\Envelope;

class StartReplier implements ReplierInterface
{
    public function supports(Envelope $envelope): bool
    {
        return '/start' === $envelope->getMessage()->text;
    }

    public function reply(Envelope $envelope): Reply
    {
        return new Reply(sprintf('Welcome %s! :) Use /help to see all commands.', $envelope->message->from->firstName));
    }
}
