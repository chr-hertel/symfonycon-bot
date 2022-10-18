<?php

declare(strict_types=1);

namespace App\SymfonyCon;

use App\Repository\SlotRepository;

final class TimerFactory
{
    private \DateTimeImmutable $now;

    public function __construct(private readonly SlotRepository $repository, string $now = null)
    {
        $this->now = new \DateTimeImmutable($now ?? 'now');
    }

    public function createTimer(): Timer
    {
        $start = $this->repository->findFirstSlot()?->getStart() ?? new \DateTimeImmutable();
        $end = $this->repository->findLastSlot()?->getEnd() ?? new \DateTimeImmutable();

        return new Timer($start, $end, $this->now);
    }
}
