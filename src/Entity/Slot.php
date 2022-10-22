<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SlotRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SlotRepository::class)]
class Slot
{
    #[ORM\Column(type: 'integer'), ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    public function __construct(
        #[ORM\Column]
        private readonly string $title,
        #[ORM\Column(type: 'datetime_immutable')]
        private readonly \DateTimeImmutable $start,
        #[ORM\Column(type: 'datetime_immutable')]
        private readonly \DateTimeImmutable $end,
        #[ORM\Column(nullable: true)]
        private readonly string|null $speaker = null,
        #[ORM\Column(nullable: true)]
        private readonly string|null $track = null,
        #[ORM\Column(type: 'text', nullable: true)]
        private readonly string|null $description = null,
    ) {
    }

    #[Groups('searchable')]
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getStart(): \DateTimeImmutable
    {
        return $this->start;
    }

    public function getEnd(): \DateTimeImmutable
    {
        return $this->end;
    }

    #[Groups('searchable')]
    public function getDescription(): string|null
    {
        return $this->description;
    }

    public function __toString(): string
    {
        $text = sprintf('*%s*', $this->title);

        if (null !== $this->speaker) {
            $text .= PHP_EOL.sprintf('_%s_', $this->speaker);
        }

        $time = sprintf('%s-%s', $this->start->format('H:i'), $this->end->format('H:i'));
        if (null !== $this->track) {
            $text = sprintf('%s (%s)', $this->track, $time).PHP_EOL.$text;
        } else {
            $text = $time.PHP_EOL.$text;
        }

        return $text;
    }
}
