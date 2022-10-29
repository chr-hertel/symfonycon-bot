<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SlotRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SlotRepository::class)]
class Slot
{
    #[ORM\Id, ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    public function __construct(
        #[ORM\Column]
        private readonly string $title,
        #[ORM\Column(type: 'datetime_immutable')]
        private \DateTimeImmutable $start,
        #[ORM\Column(type: 'datetime_immutable')]
        private \DateTimeImmutable $end,
        #[ORM\Column(nullable: true)]
        private readonly string|null $speaker = null,
        #[ORM\Column(nullable: true)]
        private readonly string|null $track = null,
        #[ORM\Column(type: 'text', nullable: true)]
        private readonly string|null $description = null,
    ) {
        $this->id = Uuid::v4();

        $this->start = $this->enforceParisTimeZone($this->start);
        $this->end = $this->enforceParisTimeZone($this->end);
    }

    public function getId(): string
    {
        return $this->id->toRfc4122();
    }

    #[Groups('searchable')]
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTimeSpan(): string
    {
        return sprintf('%s - %s', $this->getStart()->format('M d: H:i'), $this->getEnd()->format('H:i'));
    }

    public function getStart(): \DateTimeImmutable
    {
        return $this->enforceParisTimeZone($this->start);
    }

    public function getEnd(): \DateTimeImmutable
    {
        return $this->enforceParisTimeZone($this->end);
    }

    public function getSpeaker(): ?string
    {
        return $this->speaker;
    }

    public function getTrack(): ?string
    {
        return $this->track;
    }

    #[Groups('searchable')]
    public function getDescription(): string|null
    {
        return $this->description;
    }

    public function __toString(): string
    {
        $text = $this->getTimeSpan();

        if (null !== $this->track) {
            $text .= PHP_EOL.$this->track;
        }

        $text .= PHP_EOL.PHP_EOL.sprintf('*%s*', $this->title);

        if (null !== $this->speaker) {
            $text .= PHP_EOL.sprintf('_%s_', $this->speaker);
        }

        return $text;
    }

    private function enforceParisTimeZone(\DateTimeImmutable $dateTime): \DateTimeImmutable
    {
        return $dateTime->setTimezone(new \DateTimeZone('Europe/Paris'));
    }
}
