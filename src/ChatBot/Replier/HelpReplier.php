<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Reply;
use App\ChatBot\Telegram\Data\Envelope;

class HelpReplier implements ReplierInterface
{
    public function supports(Envelope $envelope): bool
    {
        return '/help' === $envelope->getMessage()->text;
    }

    public function reply(Envelope $envelope): Reply
    {
        $help = <<<HELP
            /today - lists all talks of today
            /now - lists all talks happening right now
            /next - lists all talks happening next slot
            HELP;

        return new Reply($help);
    }
}
