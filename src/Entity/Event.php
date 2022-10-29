<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorMap(['event' => Event::class, 'talk' => Talk::class])]
class Event
{
    #[ORM\Id, ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    public function __construct(
        #[ORM\Column]
        private readonly string $title,
        #[ORM\Embedded(class: TimeSpan::class, columnPrefix: false)]
        private readonly TimeSpan $timeSpan,
        #[ORM\ManyToOne(targetEntity: Slot::class, inversedBy: 'events')]
        private readonly Slot $slot,
    ) {
        $this->id = Uuid::v4();
    }

    public function getId(): string
    {
        return $this->id->toRfc4122();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTimeSpan(): TimeSpan
    {
        return $this->timeSpan;
    }

    public function getSlot(): Slot
    {
        return $this->slot;
    }
}
