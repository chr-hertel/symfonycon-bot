<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Telegram\Data\Update;
use Symfony\Component\Notifier\Message\ChatMessage;

final class StartReplier extends CommandReplier
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

    public function reply(Update $update): ChatMessage
    {
        return new ChatMessage(sprintf(
            "Welcome to SymfonyConBot, %s! :)\nUse /help to see all commands.",
            $update->getMessage()->from->firstName
        ));
    }
}
