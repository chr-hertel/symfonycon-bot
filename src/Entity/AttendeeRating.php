<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\UniqueConstraint(columns: ['talk_id', 'attendee'])]
class AttendeeRating
{
    #[ORM\Column(type: 'integer')]
    #[ORM\Id, ORM\GeneratedValue('AUTO')]
    private int $id;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: Talk::class)]
        private readonly Talk $talk,
        #[ORM\Column(type: 'integer')]
        private readonly int $attendee,
        #[ORM\Column(enumType: Rating::class)]
        private readonly Rating $rating,
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

    public function getRating(): Rating
    {
        return $this->rating;
    }
}
