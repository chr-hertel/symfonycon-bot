<?php

declare(strict_types=1);

namespace App\SymfonyCon;

use App\Entity\Slot;
use App\Repository\SlotRepository;

class Schedule
{
    private $timer;
    private $slotRepository;

    public function __construct(Timer $timer, SlotRepository $repository)
    {
        $this->timer = $timer;
        $this->slotRepository = $repository;
    }

    /**
     * @return Slot[]
     */
    public function now(): array
    {
        if (!$this->timer->isRunning()) {
            return [];
        }

        return $this->slotRepository->findByTime($this->timer->getNow());
    }

    /**
     * @return Slot[]
     */
    public function next(): array
    {
        if (!$this->timer->isRunning()) {
            return [];
        }

        return $this->slotRepository->findNext($this->timer->getNow());
    }

    /**
     * @return Slot[]
     */
    public function today(): array
    {
        if (!$this->timer->isRunning()) {
            return [];
        }

        return $this->slotRepository->findByDay($this->timer->getNow());
    }

    /**
     * @return Slot[]
     */
    public function day1(): array
    {
        return $this->slotRepository->findByDay($this->timer->getStart());
    }

    /**
     * @return Slot[]
     */
    public function day2(): array
    {
        return $this->slotRepository->findByDay($this->timer->getEnd());
    }
}
