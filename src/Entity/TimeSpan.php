<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class TimeSpan
{
    public function __construct(
        #[ORM\Column(type: 'datetime_immutable')]
        private \DateTimeImmutable $start,
        #[ORM\Column(type: 'datetime_immutable')]
        private \DateTimeImmutable $end,
    ) {
        $this->start = $this->enforceParisTimeZone($this->start);
        $this->end = $this->enforceParisTimeZone($this->end);

        if ($this->start > $this->end) {
            throw new \InvalidArgumentException('The time span needs to start before it ends.');
        }
    }

    public function getStart(): \DateTimeImmutable
    {
        return $this->enforceParisTimeZone($this->start);
    }

    public function getEnd(): \DateTimeImmutable
    {
        return $this->enforceParisTimeZone($this->end);
    }

    public function toString(): string
    {
        return sprintf('%s - %s', $this->getStart()->format('M d: H:i'), $this->getEnd()->format('H:i'));
    }

    private function enforceParisTimeZone(\DateTimeImmutable $dateTime): \DateTimeImmutable
    {
        return $dateTime->setTimezone(new \DateTimeZone('Europe/Paris'));
    }
}
