<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SlotRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SlotRepository::class)]
class Slot
{
    #[ORM\Column(type: 'integer'), ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    public function __construct(
        #[ORM\Column]
        private string $title,
        #[ORM\Column(type: 'datetime_immutable')]
        private \DateTimeImmutable $start,
        #[ORM\Column(type: 'datetime_immutable')]
        private \DateTimeImmutable $end,
        #[ORM\Column(nullable: true)]
        private string|null $speaker = null,
        #[ORM\Column(nullable: true)]
        private string|null $track = null,
    ) {
    }

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

    public function __toString(): string
    {
        $text = sprintf('*%s*', $this->title);

        if (null !== $this->speaker) {
            $text .= PHP_EOL.sprintf('_%s_', $this->speaker);
        }

        $time = sprintf('%s-%s', $this->start->format('H:i'), $this->end->format('H:i'));
        if (null !== $this->track) {
            $text = sprintf('%s Track (%s)', $this->track, $time).PHP_EOL.$text;
        } else {
            $text = $time.PHP_EOL.$text;
        }

        return $text;
    }
}
