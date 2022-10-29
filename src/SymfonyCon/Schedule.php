<?php

declare(strict_types=1);

namespace App\SymfonyCon;

use App\Entity\Slot;
use App\Repository\SlotRepository;

class Schedule
{
    public function __construct(
        private readonly Timer $timer,
        private readonly SlotRepository $slotRepository
    ) {
    }

    public function now(): ?Slot
    {
        return $this->slotRepository->findByTime($this->timer->getNow());
    }

    public function next(): ?Slot
    {
        if ($this->timer->isOver()) {
            return null;
        }

        return $this->timer->isRunning() ? $this->now()?->getNext() : $this->slotRepository->findFirst();
    }

    /**
     * @return list<Slot>
     */
    public function today(): array
    {
        return $this->slotRepository->findByDay($this->timer->getNow());
    }

    /**
     * @return list<Slot>
     */
    public function day1(): array
    {
        return $this->slotRepository->findByDay($this->timer->getStart());
    }

    /**
     * @return list<Slot>
     */
    public function day2(): array
    {
        return $this->slotRepository->findByDay($this->timer->getEnd());
    }
}
