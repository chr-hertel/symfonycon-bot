<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\UniqueConstraint(columns: ['talk_id', 'attendee'])]
class Attendance
{
    #[ORM\Column(type: 'integer')]
    #[ORM\Id, ORM\GeneratedValue('AUTO')]
    private int $id;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: Talk::class)]
        private readonly Talk $talk,
        #[ORM\Column(type: 'integer')]
        private readonly int $attendee,
    ) {
    }

    public function getTalk(): Talk
    {
        return $this->talk;
    }

    public function getAttendee(): int
    {
        return $this->attendee;
    }
}
