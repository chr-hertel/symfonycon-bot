<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Telegram\Data\Update;
use Symfony\Component\Notifier\Message\ChatMessage;

final class HelpReplier extends CommandReplier
{
    public function getCommand(): string
    {
        return 'help';
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
        $help = <<<HELP
            <b>SymfonyConBot Help</b>
            This bot will help you to keep on track with all talks at SymfonyCon Disneyland Paris 2022.
            
            <b>Until SymfonyCon starts:</b>
            /countdown - time until SymfonyCon starts
            /day1 - lists all talks of the first day
            /day2 - lists all talks of the second day
            
            <b>While SymfonyCon:</b>
            /today - lists all talks of today
            /now - lists all talks happening right now
            /next - lists all talks happening next slot
            
            <b>About SymfonyConBot:</b>
            Written with Symfony 6 and Notifier
            Checkout <a href="https://github.com/chr-hertel/symfonycon-bot">GitHub</a> for more...
            HELP;

        return new ChatMessage($help);
    }
}
