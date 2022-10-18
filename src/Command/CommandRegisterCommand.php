<?php

declare(strict_types=1);

namespace App\Command;

use App\ChatBot\Replier\CommandReplier;
use App\ChatBot\Telegram\Client;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:command:register', description: 'Command to register the application\'s commands')]
final class CommandRegisterCommand extends Command
{
    /**
     * @param iterable<CommandReplier> $commandRepliers
     */
    public function __construct(
        private readonly iterable $commandRepliers,
        private readonly Client $telegramClient,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Registering Bot Commands at Telegram');

        if (!$io->confirm('Really want to replace the registered commands?', false)) {
            return 0;
        }

        $commands = [];
        foreach ($this->commandRepliers as $replier) {
            if (!$replier->registerCommand()) {
                continue;
            }
            $commands[] = [
                'command' => $replier->getCommand(),
                'description' => $replier->getDescription(),
            ];
        }
        $this->telegramClient->registerCommands($commands);

        $io->success('Done');

        return 0;
    }
}
