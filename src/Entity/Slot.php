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
}
