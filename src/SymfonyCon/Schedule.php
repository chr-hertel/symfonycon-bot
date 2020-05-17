<?php

declare(strict_types=1);

namespace App\SymfonyCon;

use App\Repository\SlotRepository;

class Schedule
{
    private Timer $timer;
    private SlotRepository $slotRepository;

    public function __construct(Timer $timer, SlotRepository $repository)
    {
        $this->timer = $timer;
        $this->slotRepository = $repository;
    }

    public function now(): SlotCollection
    {
        if (!$this->timer->isRunning()) {
            return SlotCollection::empty();
        }

        return SlotCollection::array($this->slotRepository->findByTime($this->timer->getNow()));
    }

    public function next(): SlotCollection
    {
        if (!$this->timer->isRunning() && !$this->timer->startsToday()) {
            return SlotCollection::empty();
        }

        return SlotCollection::array($this->slotRepository->findNext($this->timer->getNow()));
    }

    public function today(): SlotCollection
    {
        if (!$this->timer->isRunning() && !$this->timer->startsToday()) {
            return SlotCollection::empty();
        }

        return SlotCollection::array($this->slotRepository->findByDay($this->timer->getNow()));
    }

    public function day1(): SlotCollection
    {
        return SlotCollection::array($this->slotRepository->findByDay($this->timer->getStart()));
    }

    public function day2(): SlotCollection
    {
        return SlotCollection::array($this->slotRepository->findByDay($this->timer->getEnd()));
    }
}
