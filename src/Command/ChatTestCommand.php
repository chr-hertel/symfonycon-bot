<?php

declare(strict_types=1);

namespace App\Command;

use App\ChatBot\ReplyMachine;
use App\ChatBot\Telegram\Data\Envelope;
use App\ChatBot\Telegram\Data\Message;
use App\ChatBot\Telegram\Data\User;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:chat:reply', description: 'Command to test chat without hijacking Telegram bot')]
class ChatTestCommand extends Command
{
    public function __construct(
        private readonly ReplyMachine $replyMachine,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Chat Reply Test');

        /** @var string $name */
        $name = $io->ask('What\'s your name?') ?? 'noname';

        while ($text = $io->ask('What\'s your message?')) {
            $sender = new User();
            $sender->firstName = ucfirst($name);

            $message = new Message();
            $message->text = $text;
            $message->from = $sender;

            $envelope = new Envelope();
            $envelope->message = $message;

            $reply = $this->replyMachine->findReply($envelope);
            $io->writeln($reply->getText());
            $io->newLine();
        }

        $io->note('Bye');

        return 0;
    }
}
