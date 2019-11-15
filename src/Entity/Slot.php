<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SlotRepository")
 */
class Slot
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column
     */
    private $title;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $end;

    /**
     * @var string|null
     *
     * @ORM\Column(nullable=true)
     */
    private $speaker;

    /**
     * @var string|null
     *
     * @ORM\Column(nullable=true)
     */
    private $track;

    public function __construct(
        string $title,
        \DateTimeImmutable $start,
        \DateTimeImmutable $end,
        string $speaker = null,
        string $track = null
    ) {
        $this->title = $title;
        $this->start = $start;
        $this->end = $end;
        $this->speaker = $speaker;
        $this->track = $track;
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

    public function getSpeaker(): ?string
    {
        return $this->speaker;
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
