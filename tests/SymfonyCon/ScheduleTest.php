<?php

declare(strict_types=1);

namespace App\Tests\SymfonyCon;

use App\SymfonyCon\Schedule;
use App\SymfonyCon\Timer;
use App\Tests\ConferenceFixtures;
use PHPUnit\Framework\TestCase;

final class ScheduleTest extends TestCase
{
    use ConferenceFixtures {
        setUp as fixtureSetUp;
    }

    private Schedule $scheduleBefore;
    private Schedule $scheduleStartingMorning;
    private Schedule $scheduleWhileRunning;
    private Schedule $scheduleAfter;

    public function testNowBefore(): void
    {
        static::assertCount(0, $this->scheduleBefore->now());
    }

    public function testNowStartingMorning(): void
    {
        static::assertCount(0, $this->scheduleStartingMorning->now());
    }

    public function testNowWhileRunning(): void
    {
        static::assertCount(3, $this->scheduleWhileRunning->now());
    }

    public function testNowAfter(): void
    {
        static::assertCount(0, $this->scheduleAfter->now());
    }

    public function testNextBefore(): void
    {
        static::assertCount(0, $this->scheduleBefore->next());
    }

    public function testNextStartingMorning(): void
    {
        static::assertCount(1, $this->scheduleStartingMorning->next());
    }

    public function testNextWhileRunning(): void
    {
        static::assertCount(1, $this->scheduleWhileRunning->next());
    }

    public function testNextAfter(): void
    {
        static::assertCount(0, $this->scheduleAfter->next());
    }

    public function testTodayBefore(): void
    {
        static::assertCount(0, $this->scheduleBefore->today());
    }

    public function testTodayStartingMorning(): void
    {
        static::assertCount(23, $this->scheduleStartingMorning->today());
    }

    public function testTodayWhileRunning(): void
    {
        static::assertCount(22, $this->scheduleWhileRunning->today());
    }

    public function testTodayAfter(): void
    {
        static::assertCount(0, $this->scheduleAfter->today());
    }

    public function testDay1Before(): void
    {
        static::assertCount(23, $this->scheduleBefore->day1());
    }

    public function testDay1StartingMorning(): void
    {
        static::assertCount(23, $this->scheduleStartingMorning->day1());
    }

    public function testDay1WhileRunning(): void
    {
        static::assertCount(23, $this->scheduleWhileRunning->day1());
    }

    public function testDay1After(): void
    {
        static::assertCount(23, $this->scheduleAfter->day1());
    }

    public function testDay2Before(): void
    {
        static::assertCount(22, $this->scheduleBefore->day2());
    }

    public function testDay2StartingMorning(): void
    {
        static::assertCount(22, $this->scheduleStartingMorning->day2());
    }

    public function testDay2WhileRunning(): void
    {
        static::assertCount(22, $this->scheduleWhileRunning->day2());
    }

    public function testDay2After(): void
    {
        static::assertCount(22, $this->scheduleAfter->day2());
    }

    protected function setUp(): void
    {
        $this->fixtureSetUp();

        $timerBefore = $this->getTimerWithNow('11/20/19 08:00');
        $this->scheduleBefore = new Schedule($timerBefore, $this->repository);

        $timerStartingMorning = $this->getTimerWithNow('11/21/19 06:50');
        $this->scheduleStartingMorning = new Schedule($timerStartingMorning, $this->repository);

        $timerWhileRunning = $this->getTimerWithNow('11/22/19 14:55');
        $this->scheduleWhileRunning = new Schedule($timerWhileRunning, $this->repository);

        $timerAfter = $this->getTimerWithNow('11/23/19 14:00');
        $this->scheduleAfter = new Schedule($timerAfter, $this->repository);
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
