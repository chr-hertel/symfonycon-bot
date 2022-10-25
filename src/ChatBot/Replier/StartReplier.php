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
        return new ChatMessage(
            sprintf('<b>Welcome to SymfonyConBot, %s! :)</b>', $update->getMessage()->from->firstName)
            .PHP_EOL.PHP_EOL.
            'Use /help to see all commands.'
        );
    }
}
