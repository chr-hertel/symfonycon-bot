<?php

declare(strict_types=1);

namespace App\Command;

use App\SymfonyCon\Analyzer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:conference:analysis', description: 'Runs an analysis on the gathered data')]
final class ConferenceAnalysisCommand extends Command
{
    public function __construct(private readonly Analyzer $analyzer)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Conference Analysis');
        $io->text('Let\'s see how the talks performed ...');
        $io->newLine();

        $io->table(
            ['Talk', 'Speaker', 'Attendees', 'No of Ratings', 'Average Rating'],
            $this->analyzer->createAnalysis(),
        );

        return 0;
    }
}
