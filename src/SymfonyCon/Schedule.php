<?php

declare(strict_types=1);

namespace App\SymfonyCon;

use App\Entity\Slot;
use App\Repository\SlotRepository;

class Schedule
{
    private $timer;
    private $repository;

    public function __construct(Timer $timer, SlotRepository $repository)
    {
        $this->timer = $timer;
        $this->repository = $repository;
    }

    /**
     * @return Slot[]
     */
    public function now(): array
    {
        if (!$this->timer->isRunning()) {
            return [];
        }

        return $this->repository->findByTime($this->timer->getNow());
    }

    /**
     * @return Slot[]
     */
    public function next(): array
    {
        if (!$this->timer->isRunning()) {
            return [];
        }

        return $this->repository->findNext($this->timer->getNow());
    }

    /**
     * @return Slot[]
     */
    public function today(): array
    {
        if (!$this->timer->isRunning()) {
            return [];
        }

        return $this->repository->findByDay($this->timer->getNow());
    }

    /**
     * @return Slot[]
     */
    public function day1(): array
    {
        return $this->repository->findByDay($this->timer->getStart());
    }

    /**
     * @return Slot[]
     */
    public function day2(): array
    {
        return $this->repository->findByDay($this->timer->getEnd());
    }
}
