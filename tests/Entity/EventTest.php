<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Event;
use App\Entity\Slot;
use App\Entity\TimeSpan;
use PHPUnit\Framework\TestCase;

final class EventTest extends TestCase
{
    public function testConstruct(): void
    {
        $start = new \DateTimeImmutable('12.12.2012 12:12');
        $timeSpan = new TimeSpan($start, $start->modify('+45 minutes'));
        $slot = new Slot($timeSpan);
        $event = new Event('Lunch Break', $timeSpan, $slot);

        $uuidPattern = '#[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}#';
        self::assertMatchesRegularExpression($uuidPattern, $event->getId());
        self::assertSame('Lunch Break', $event->getTitle());
        self::assertSame($timeSpan, $event->getTimeSpan());
        self::assertSame($slot, $event->getSlot());
    }
}
