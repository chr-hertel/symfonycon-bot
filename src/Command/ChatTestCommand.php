<?php

declare(strict_types=1);

namespace App\Command;

use App\ChatBot\ReplyMachine;
use App\ChatBot\Telegram\Data\Envelope;
use App\ChatBot\Telegram\Data\Message;
use App\ChatBot\Telegram\Data\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ChatTestCommand extends Command
{
    protected static $defaultName = 'app:chat:reply';

    private ReplyMachine $replyMachine;

    public function __construct(ReplyMachine $replyMachine)
    {
        $this->replyMachine = $replyMachine;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Chat Reply Test');

        $name = $io->ask('What\'s your name?') ?? 'noname';

        while (null !== $text = $io->ask('What\'s your message?')) {
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
