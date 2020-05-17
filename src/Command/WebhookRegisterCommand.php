<?php

declare(strict_types=1);

namespace App\Command;

use App\ChatBot\Telegram\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class WebhookRegisterCommand extends Command
{
    protected static $defaultName = 'app:webhook:register';

    private Client $telegramClient;

    public function __construct(Client $telegramClient)
    {
        $this->telegramClient = $telegramClient;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Registering Telegram Webhook');

        if (!$io->confirm('Really wan\'t to replace the webhook?', false)) {
            return 0;
        }

        $this->telegramClient->registerWebhook();

        $io->success('Done');

        return 0;
    }
}
