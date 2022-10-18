<?php

declare(strict_types=1);

namespace App\Command;

use App\SymfonyCon\Crawler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:schedule:crawl', description: 'Load conference schedule from live.symfony.com')]
final class ScheduleCrawlerCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly Crawler $crawler,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Crawling latest schedule information from live.symfony.com');

        if (!$io->confirm('Really want to replace the current schedule?', false)) {
            return 0;
        }

        $this->truncateSlots();
        $this->crawler->loadSchedule();

        return 0;
    }

    private function truncateSlots(): void
    {
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();

        $connection->executeStatement($platform->getTruncateTableSQL('slot', true));
    }
}
