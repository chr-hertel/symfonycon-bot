<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Slot;
use App\Tests\ConferenceFixtures;
use App\Tests\SchemaSetup;
use App\Tests\TestDatabase;
use PHPUnit\Framework\TestCase;

final class SlotRepositoryTest extends TestCase
{
    use TestDatabase;
    use SchemaSetup;
    use ConferenceFixtures;

    protected function setUp(): void
    {
        $this->setUpDatabase();
        $this->setUpSchema();
        $this->setUpFixtures();
    }

    /**
     * @dataProvider provideDays
     */
    public function testFindByDay(string $date, int $expectedCount, string $cacheKey): void
    {
        $dateTime = new \DateTimeImmutable($date);
        $slots = $this->repository->findByDay($dateTime);

        self::assertCount($expectedCount, array_filter($slots, static function (Slot $slot) use ($dateTime) {
            $dayStart = $dateTime->modify('midnight');
            $dayEnd = $dateTime->modify('midnight +1 day');
            $start = $slot->getTimeSpan()->getStart();

            return $dayStart < $start && $start < $dayEnd;
        }));
        self::assertTrue($this->resultCache->hasItem($cacheKey));
    }

    /**
     * @return array<string, array{0: string, 1: int, 2: string}>
     */
    public function provideDays(): array
    {
        return [
            'day1' => ['11/21/19 08:00', 13, 'schedule-2019-11-21'],
            'day2' => ['11/22/19 17:00', 12, 'schedule-2019-11-22'],
        ];
    }

    /**
     * @dataProvider provideTimes
     *
     * @param array<string> $titles
     */
    public function testFindByTime(string $time, array $titles): void
    {
        $slot = $this->repository->findByTime(new \DateTimeImmutable($time));
        self::assertInstanceOf(Slot::class, $slot);

        $events = $slot->getEvents();
        self::assertCount(count($titles), $events);
        foreach ($events as $i => $event) {
            self::assertSame($titles[$i], $event->getTitle());
        }
    }

    /**
     * @return array<string, array{0: string, 1: array<string>}>
     */
    public function provideTimes(): array
    {
        return [
            'day1_keynote' => ['11/21/19 09:36', ['Keynote']],
            'day1_lunch' => ['11/21/19 13:15', ['Lunch']],
            'day1_slot2' => ['11/21/19 11:32', ['How Doctrine caching can skyrocket your application', 'Using the Workflow component for e-commerce', 'Crazy Fun Experiments with PHP (Not for Production)']],
            'day2_slot1' => ['11/22/19 10:08', ['Using API Platform to build ticketing system', 'Make the Most out of Twig', 'Mental Health in the Workplace']],
            'day2_closing' => ['11/22/19 16:57', ['Closing session']],
        ];
    }

    public function testGetTimeSpan(): void
    {
        $result = $this->repository->getTimeSpan();

        self::assertArrayHasKey('start', $result);
        self::assertArrayHasKey('end', $result);
        self::assertEquals(new \DateTimeImmutable('11/21/19 8:00'), $result['start']);
        self::assertEquals(new \DateTimeImmutable('11/22/19 17:00'), $result['end']);
    }
}
