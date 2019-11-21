<?php

declare(strict_types=1);

namespace App\SymfonyCon;

class Timer
{
    private $start;
    private $end;
    private $now;

    public function __construct(string $start, string $end, string $now = null)
    {
        $this->start = new \DateTimeImmutable($start);
        $this->end = new \DateTimeImmutable($end);
        $this->now = new \DateTimeImmutable($now ?? 'now');
    }

    public function getStart(): \DateTimeImmutable
    {
        return $this->start;
    }

    public function getEnd(): \DateTimeImmutable
    {
        return $this->end;
    }

    public function getNow(): \DateTimeImmutable
    {
        return $this->now;
    }

    public function isOver(): bool
    {
        return $this->now >= $this->end;
    }

    public function hasStarted(): bool
    {
        return $this->now >= $this->start;
    }

    public function isRunning(): bool
    {
        return $this->hasStarted() && !$this->isOver();
    }

    public function getCountdown(): \DateInterval
    {
        return $this->start->diff($this->now);
    }

    public function startsToday()
    {
        return $this->start->format('m/d/y') === $this->now->format('m/d/y');
    }
}
