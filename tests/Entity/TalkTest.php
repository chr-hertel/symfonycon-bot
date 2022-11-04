<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Slot;
use App\Entity\Talk;
use App\Entity\TimeSpan;
use App\Entity\Track;
use PHPUnit\Framework\TestCase;

final class TalkTest extends TestCase
{
    private Talk $talk;

    protected function setUp(): void
    {
        $start = new \DateTimeImmutable('12.12.2012 12:12');
        $timeSpan = new TimeSpan($start, $start->modify('+45 minutes'));
        $slot = new Slot($timeSpan);
        $this->talk = new Talk('Working with events', 'John Doe', 'This is a dummy', $timeSpan, Track::SymfonyRoom, $slot);
    }

    public function testConstruct(): void
    {
        $start = new \DateTimeImmutable('12.12.2012 12:12');
        $timeSpan = new TimeSpan($start, $start->modify('+45 minutes'));

        $uuidPattern = '#[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}#';
        self::assertMatchesRegularExpression($uuidPattern, $this->talk->getId());
        self::assertSame('Working with events', $this->talk->getTitle());
        self::assertSame('John Doe', $this->talk->getSpeaker());
        self::assertSame('This is a dummy', $this->talk->getDescription());
        self::assertEquals($timeSpan, $this->talk->getTimeSpan());
        self::assertSame('The Symfony room', $this->talk->getTrack());
    }

    public function testIsOver(): void
    {
        self::assertFalse($this->talk->isOver(new \DateTimeImmutable('11.12.2012 18:00')));
        self::assertTrue($this->talk->isOver(new \DateTimeImmutable('12.12.2012 18:00')));
    }
}
