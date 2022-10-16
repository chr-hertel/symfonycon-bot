<?php

declare(strict_types=1);

namespace App\Command;

use App\ChatBot\Telegram\Client;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:webhook:register', description: 'Command to register the application as webhook')]
class WebhookRegisterCommand extends Command
{
    public function __construct(
        private readonly Client $telegramClient
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Registering Telegram Webhook');

        if (!$io->confirm('Really want to replace the webhook?', false)) {
            return 0;
        }

        $this->telegramClient->registerWebhook();

        $io->success('Done');

        return 0;
    }
}
