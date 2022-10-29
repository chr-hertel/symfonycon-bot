<?php

declare(strict_types=1);

namespace App\Tests\SymfonyCon;

use App\SymfonyCon\Schedule;
use App\SymfonyCon\Timer;
use App\Tests\ConferenceFixtures;
use App\Tests\SchemaSetup;
use App\Tests\TestDatabase;
use PHPUnit\Framework\TestCase;

final class ScheduleTest extends TestCase
{
    use TestDatabase;
    use SchemaSetup;
    use ConferenceFixtures;

    private Schedule $scheduleBefore;
    private Schedule $scheduleStartingMorning;
    private Schedule $scheduleWhileRunning;
    private Schedule $scheduleAfter;

    public function testNowBefore(): void
    {
        self::assertNull($this->scheduleBefore->now());
    }

    public function testNowStartingMorning(): void
    {
        self::assertNull($this->scheduleStartingMorning->now());
    }

    public function testNowWhileRunning(): void
    {
        $slot = $this->scheduleWhileRunning->now();
        self::assertNotNull($slot);
        self::assertCount(3, $slot->getEvents());
    }

    public function testNowAfter(): void
    {
        self::assertNull($this->scheduleAfter->now());
    }

    public function testNextBefore(): void
    {
        $slot = $this->scheduleBefore->next();
        self::assertNotNull($slot);
        self::assertCount(1, $slot->getEvents());
    }

    public function testNextStartingMorning(): void
    {
        $slot = $this->scheduleStartingMorning->next();
        self::assertNotNull($slot);
        self::assertCount(1, $slot->getEvents());
    }

    public function testNextWhileRunning(): void
    {
        $slot = $this->scheduleWhileRunning->next();
        self::assertNotNull($slot);
        self::assertCount(1, $slot->getEvents());
    }

    public function testNextAfter(): void
    {
        self::assertNull($this->scheduleAfter->next());
    }

    public function testTodayBefore(): void
    {
        self::assertCount(0, $this->scheduleBefore->today());
    }

    public function testTodayStartingMorning(): void
    {
        self::assertCount(13, $this->scheduleStartingMorning->today());
    }

    public function testTodayWhileRunning(): void
    {
        self::assertCount(12, $this->scheduleWhileRunning->today());
    }

    public function testTodayAfter(): void
    {
        self::assertCount(0, $this->scheduleAfter->today());
    }

    public function testDay1Before(): void
    {
        self::assertCount(13, $this->scheduleBefore->day1());
    }

    public function testDay1StartingMorning(): void
    {
        self::assertCount(13, $this->scheduleStartingMorning->day1());
    }

    public function testDay1WhileRunning(): void
    {
        self::assertCount(13, $this->scheduleWhileRunning->day1());
    }

    public function testDay1After(): void
    {
        self::assertCount(13, $this->scheduleAfter->day1());
    }

    public function testDay2Before(): void
    {
        self::assertCount(12, $this->scheduleBefore->day2());
    }

    public function testDay2StartingMorning(): void
    {
        self::assertCount(12, $this->scheduleStartingMorning->day2());
    }

    public function testDay2WhileRunning(): void
    {
        self::assertCount(12, $this->scheduleWhileRunning->day2());
    }

    public function testDay2After(): void
    {
        self::assertCount(12, $this->scheduleAfter->day2());
    }

    protected function setUp(): void
    {
        $this->setUpDatabase();
        $this->setUpSchema();
        $this->setUpFixtures();

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
