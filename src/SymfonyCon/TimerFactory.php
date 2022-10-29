<?php

declare(strict_types=1);

namespace App\SymfonyCon;

use App\Repository\SlotRepository;
use Symfony\Component\Clock\ClockInterface;

final class TimerFactory
{
    public function __construct(
        private readonly SlotRepository $repository,
        private readonly ClockInterface $clock,
    ) {
    }

    public function createTimer(): Timer
    {
        ['start' => $start, 'end' => $end] = $this->repository->getTimeSpan();

        return new Timer($start, $end, $this->clock->now());
    }
}
