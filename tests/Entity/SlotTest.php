<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Event;
use App\Entity\Slot;
use App\Entity\TimeSpan;
use PHPUnit\Framework\TestCase;

final class SlotTest extends TestCase
{
    private Slot $slot;

    protected function setUp(): void
    {
        $start = new \DateTimeImmutable('12.12.2012 12:12');
        $timeSpan = new TimeSpan($start, $start->modify('+45 minutes'));
        $this->slot = new Slot($timeSpan);
    }

    public function testConstructWithoutSlots(): void
    {
        $start = new \DateTimeImmutable('12.12.2012 12:12');
        $timeSpan = new TimeSpan($start, $start->modify('+45 minutes'));

        $uuidPattern = '#[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}#';
        self::assertMatchesRegularExpression($uuidPattern, $this->slot->getId());
        self::assertEquals($timeSpan, $this->slot->getTimeSpan());
        self::assertCount(0, $this->slot->getEvents());
    }

    public function testConstructWithSlots(): void
    {
        $slotPrev = $this->slot;
        $startNext = new \DateTimeImmutable('12.12.2012 13:12');
        $timeSpanNext = new TimeSpan($startNext, $startNext->modify('+45 minutes'));
        $slotNext = new Slot($timeSpanNext);
        $start = new \DateTimeImmutable('12.12.2012 14:12');
        $timeSpan = new TimeSpan($start, $start->modify('+45 minutes'));
        $slot = new Slot($timeSpan, $slotPrev, $slotNext);

        self::assertSame($slotPrev, $slot->getPrevious());
        self::assertSame($slotNext, $slot->getNext());
        self::assertFalse($slot->isFirst());
        self::assertFalse($slot->isLast());
    }

    public function testExceptionOnGetterWithoutPrevious(): void
    {
        self::expectException(\DomainException::class);

        $this->slot->getPrevious();
    }

    public function testExceptionOnGetterWithoutNext(): void
    {
        self::expectException(\DomainException::class);

        $this->slot->getNext();
    }

    public function testSingleSlotIsFirstAndLast(): void
    {
        self::assertTrue($this->slot->isFirst());
        self::assertTrue($this->slot->isLast());
    }

    public function testSlotWithNextIsNotLast(): void
    {
        $slot = clone $this->slot;
        $slot->setNext($this->slot);

        self::assertFalse($slot->isLast());
    }

    public function testSlotWithPreviousIsNotFirst(): void
    {
        $start = new \DateTimeImmutable('12.12.2012 10:12');
        $timeSpan = new TimeSpan($start, $start->modify('+45 minutes'));
        $slot = new Slot($timeSpan, $this->slot);

        self::assertFalse($slot->isFirst());
    }

    public function testAddingEvents(): void
    {
        $event = new Event('Test Event', $this->slot->getTimeSpan(), $this->slot);
        $this->slot->addEvent($event);

        $events = $this->slot->getEvents();
        self::assertCount(1, $events);
        self::assertContainsOnlyInstancesOf(Event::class, $events);
        self::assertSame([$event], $events);
    }
}
