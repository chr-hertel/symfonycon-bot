<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SlotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SlotRepository::class)]
class Slot
{
    #[ORM\Id, ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    /**
     * @phpstan-var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'slot', cascade: ['persist'])]
    private Collection $events;

    public function __construct(
        #[ORM\Embedded(class: TimeSpan::class, columnPrefix: false)]
        private readonly TimeSpan $timeSpan,
        #[ORM\OneToOne(targetEntity: Slot::class)]
        private readonly ?Slot $previous = null,
        #[ORM\OneToOne(targetEntity: Slot::class)]
        private ?Slot $next = null,
    ) {
        $this->id = Uuid::v4();
        $this->events = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id->toRfc4122();
    }

    public function getTimeSpan(): TimeSpan
    {
        return $this->timeSpan;
    }

    /**
     * @return list<Event>
     */
    public function getEvents(): array
    {
        return $this->events->toArray();
    }

    public function addEvent(Event $event): void
    {
        $this->events->add($event);
    }

    public function isFirst(): bool
    {
        return null === $this->previous;
    }

    public function getPrevious(): Slot
    {
        if (null === $this->previous) {
            throw new \DomainException('Cannot fetch previous slot of first slot.');
        }

        return $this->previous;
    }

    public function isLast(): bool
    {
        return null === $this->next;
    }

    public function getNext(): Slot
    {
        if (null === $this->next) {
            throw new \DomainException('Cannot fetch next slot of last slot.');
        }

        return $this->next;
    }

    public function setNext(Slot $next): void
    {
        $this->next = $next;
    }
}
