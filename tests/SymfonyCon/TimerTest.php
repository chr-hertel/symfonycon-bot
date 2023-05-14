<?php

declare(strict_types=1);

namespace App\Tests\SymfonyCon;

use App\SymfonyCon\Timer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class TimerTest extends TestCase
{
    public function testStartTimeGetter(): void
    {
        $timer = $this->getTimerWithNow('11/20/19 08:00');

        self::assertEquals(new \DateTimeImmutable('11/21/19 08:00'), $timer->getStart());
    }

    public function testEndTimeGetter(): void
    {
        $timer = $this->getTimerWithNow('11/20/19 08:00');

        self::assertEquals(new \DateTimeImmutable('11/22/19 17:00'), $timer->getEnd());
    }

    public function testNowTimeGetter(): void
    {
        $timer = $this->getTimerWithNow('11/20/19 08:00');

        self::assertEquals(new \DateTimeImmutable('11/20/19 08:00'), $timer->getNow());
    }

    public function testHasStartedBefore(): void
    {
        $timer = $this->getTimerWithNow('11/20/19 08:00');

        self::assertFalse($timer->hasStarted());
    }

    public function testHasStartedOnTime(): void
    {
        $timer = $this->getTimerWithNow('11/21/19 08:00');

        self::assertTrue($timer->hasStarted());
    }

    public function testHasStartedAfterwards(): void
    {
        $timer = $this->getTimerWithNow('11/22/19 08:00');

        self::assertTrue($timer->hasStarted());
    }

    public function testIsOverBefore(): void
    {
        $timer = $this->getTimerWithNow('11/20/19 08:00');

        self::assertFalse($timer->isOver());
    }

    public function testIsOverOnTime(): void
    {
        $timer = $this->getTimerWithNow('11/22/19 17:00');

        self::assertTrue($timer->isOver());
    }

    public function testIsOverAfterwards(): void
    {
        $timer = $this->getTimerWithNow('11/23/19 08:00');

        self::assertTrue($timer->isOver());
    }

    public function testIsRunningBefore(): void
    {
        $timer = $this->getTimerWithNow('11/20/19 08:00');

        self::assertFalse($timer->isRunning());
    }

    public function testIsRunningInBetween(): void
    {
        $timer = $this->getTimerWithNow('11/22/19 09:00');

        self::assertTrue($timer->isRunning());
    }

    public function testIsRunningAfterwards(): void
    {
        $timer = $this->getTimerWithNow('11/23/19 08:00');

        self::assertFalse($timer->isRunning());
    }

    public function testCountdownBefore(): void
    {
        $timer = $this->getTimerWithNow('11/18/19 19:15');
        $countdown = $timer->getCountdown();

        self::assertSame(2, $countdown->days);
        self::assertSame(12, $countdown->h);
        self::assertSame(45, $countdown->i);
    }

    public function testCountdownOnTime(): void
    {
        $timer = $this->getTimerWithNow('11/21/19 08:00');
        $countdown = $timer->getCountdown();

        self::assertSame(0, $countdown->days);
        self::assertSame(0, $countdown->h);
        self::assertSame(0, $countdown->i);
    }

    public function testCountdownWhile(): void
    {
        $timer = $this->getTimerWithNow('11/21/19 09:00');
        $countdown = $timer->getCountdown();

        self::assertSame(0, $countdown->days);
        self::assertSame(0, $countdown->h);
        self::assertSame(0, $countdown->i);
    }

    public function testCountdownAfter(): void
    {
        $timer = $this->getTimerWithNow('11/23/19 18:00');
        $countdown = $timer->getCountdown();

        self::assertSame(0, $countdown->days);
        self::assertSame(0, $countdown->h);
        self::assertSame(0, $countdown->i);
    }

    #[DataProvider('provideStartsTodayData')]
    public function testStartsToday(string $now, bool $expectedBoolean): void
    {
        $timer = $this->getTimerWithNow($now);

        self::assertSame($expectedBoolean, $timer->startsToday());
    }

    /**
     * @return array<array{0: string, 1: boolean}>
     */
    public static function provideStartsTodayData(): array
    {
        return [
            ['11/21/19 07:20', true],
            ['11/22/19 07:20', false],
            ['11/20/19 07:20', false],
            ['11/21/19 17:20', true],
        ];
    }

    private function getTimerWithNow(string $now): Timer
    {
        return new Timer(
            new \DateTimeImmutable('11/21/19 08:00'),
            new \DateTimeImmutable('11/22/19 17:00'),
            new \DateTimeImmutable($now),
        );
    }
}
