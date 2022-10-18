<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Reply;
use App\ChatBot\Telegram\Data\Envelope;

class StartReplier extends CommandReplier
{
    public function getCommand(): string
    {
        return 'start';
    }

    public function getDescription(): string
    {
        return '';
    }

    public function registerCommand(): bool
    {
        return false;
    }

    public function reply(Envelope $envelope): Reply
    {
        return new Reply(sprintf(
            "Welcome to SymfonyConBot, %s! :)\nUse /help to see all commands.",
            $envelope->getMessage()->from->firstName
        ));
    }
}
