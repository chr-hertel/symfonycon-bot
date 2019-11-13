<?php

declare(strict_types=1);

namespace App\Tests\SymfonyCon;

use App\SymfonyCon\Timer;
use PHPUnit\Framework\TestCase;

class TimerTest extends TestCase
{
    public function testStartTimeGetter(): void
    {
        $timer = new Timer('11/21/19 08:00', '11/22/19 17:00', '11/20/19 08:00');

        static::assertEquals(new \DateTimeImmutable('11/21/19 08:00'), $timer->getStart());
    }

    public function testEndTimeGetter(): void
    {
        $timer = new Timer('11/21/19 08:00', '11/22/19 17:00', '11/20/19 08:00');

        static::assertEquals(new \DateTimeImmutable('11/22/19 17:00'), $timer->getEnd());
    }

    public function testNowTimeGetter(): void
    {
        $timer = new Timer('11/21/19 08:00', '11/22/19 17:00', '11/20/19 08:00');

        static::assertEquals(new \DateTimeImmutable('11/20/19 08:00'), $timer->getNow());
    }

    public function testHasStartedBefore(): void
    {
        $timer = new Timer('11/21/19 08:00', '11/22/19 17:00', '11/20/19 08:00');

        static::assertFalse($timer->hasStarted());
    }

    public function testHasStartedOnTime(): void
    {
        $timer = new Timer('11/21/19 08:00', '11/22/19 17:00', '11/21/19 08:00');

        static::assertTrue($timer->hasStarted());
    }

    public function testHasStartedAfterwards(): void
    {
        $timer = new Timer('11/21/19 08:00', '11/22/19 17:00', '11/22/19 08:00');

        static::assertTrue($timer->hasStarted());
    }

    public function testIsOverBefore(): void
    {
        $timer = new Timer('11/21/19 08:00', '11/22/19 17:00', '11/20/19 08:00');

        static::assertFalse($timer->isOver());
    }

    public function testIsOverOnTime(): void
    {
        $timer = new Timer('11/21/19 08:00', '11/22/19 17:00', '11/22/19 17:00');

        static::assertTrue($timer->isOver());
    }

    public function testIsOverAfterwards(): void
    {
        $timer = new Timer('11/21/19 08:00', '11/22/19 17:00', '11/23/19 08:00');

        static::assertTrue($timer->isOver());
    }

    public function testIsRunningBefore(): void
    {
        $timer = new Timer('11/21/19 08:00', '11/22/19 17:00', '11/20/19 08:00');

        static::assertFalse($timer->isRunning());
    }

    public function testIsRunningInBetween(): void
    {
        $timer = new Timer('11/21/19 08:00', '11/22/19 17:00', '11/22/19 09:00');

        static::assertTrue($timer->isRunning());
    }

    public function testIsRunningAfterwards(): void
    {
        $timer = new Timer('11/21/19 08:00', '11/22/19 17:00', '11/23/19 08:00');

        static::assertFalse($timer->isRunning());
    }

    public function testCountdownBefore(): void
    {
        $timer = new Timer('11/21/19 08:00', '11/22/19 17:00', '11/18/19 19:15');
        $countdown = $timer->getCountdown();

        static::assertSame(2, $countdown->days);
        static::assertSame(12, $countdown->h);
        static::assertSame(45, $countdown->i);
    }

    public function testCountdownOnTime(): void
    {
        $timer = new Timer('11/21/19 08:00', '11/22/19 17:00', '11/21/19 08:00');
        $countdown = $timer->getCountdown();

        static::assertSame(0, $countdown->days);
        static::assertSame(0, $countdown->h);
        static::assertSame(0, $countdown->i);
    }
}
