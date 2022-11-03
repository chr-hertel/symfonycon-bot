<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TalkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TalkRepository::class)]
class Talk extends Event
{
    public function __construct(
        string $title,
        #[ORM\Column(nullable: true)]
        private readonly string $speaker,
        #[ORM\Column(type: 'text')]
        private readonly string $description,
        TimeSpan $timeSpan,
        #[ORM\Column(enumType: Track::class)]
        private readonly Track $track,
        Slot $slot,
    ) {
        parent::__construct($title, $timeSpan, $slot);
    }

    #[Groups('searchable')]
    public function getTitle(): string
    {
        return parent::getTitle();
    }

    #[Groups('searchable')]
    public function getSpeaker(): string
    {
        return $this->speaker;
    }

    #[Groups('searchable')]
    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTrack(): string
    {
        return $this->track->value;
    }

    public function isOver(\DateTimeImmutable $now): bool
    {
        return $now > $this->getTimeSpan()->getEnd();
    }
}
