<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Slot;
use App\Tests\ConferenceFixtures;
use PHPUnit\Framework\TestCase;

class SlotRepositoryTest extends TestCase
{
    use ConferenceFixtures;

    /**
     * @dataProvider provideDays
     */
    public function testFindByDay(string $date, int $expectedCount, string $cacheKey): void
    {
        $dateTime = new \DateTimeImmutable($date);
        $slots = $this->repository->findByDay($dateTime);

        static::assertCount($expectedCount, array_filter($slots, static function (Slot $slot) use ($dateTime) {
            $dayStart = $dateTime->modify('midnight');
            $dayEnd = $dateTime->modify('midnight +1 day');
            $start = $slot->getStart();

            return $dayStart < $start && $start < $dayEnd;
        }));
        static::assertTrue($this->resultCache->contains($cacheKey));
    }

    /**
     * @return array<string, array{0: string, 1: int, 2: string}>
     */
    public function provideDays(): array
    {
        return [
            'day1' => ['11/21/19 08:00', 23, 'schedule-2019-11-21'],
            'day2' => ['11/22/19 17:00', 22, 'schedule-2019-11-22'],
        ];
    }

    /**
     * @dataProvider provideTimes
     *
     * @param array<string> $titles
     */
    public function testFindByTime(string $time, array $titles): void
    {
        $slots = $this->repository->findByTime(new \DateTimeImmutable($time));

        static::assertCount(count($titles), $slots);
        foreach ($slots as $i => $slot) {
            static::assertSame($titles[$i], $slot->getTitle());
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

    /**
     * @dataProvider provideNext
     *
     * @param array<string> $titles
     */
    public function testFindNext(string $time, array $titles): void
    {
        $slots = $this->repository->findNext(new \DateTimeImmutable($time));

        static::assertCount(count($titles), $slots);
        foreach ($slots as $i => $slot) {
            static::assertSame($titles[$i], $slot->getTitle());
        }
    }

    /**
     * @return array<string, array{0: string, 1: array<string>}>
     */
    public function provideNext(): array
    {
        return [
            'day1_keynote' => ['11/21/19 09:36', ['HTTP/3: It\'s all about the transport!', 'How to contribute to Symfony and why you should give it a try', 'A view in the PHP Virtual Machine']],
            'day1_lunch' => ['11/21/19 13:15', ['Hexagonal Architecture with Symfony', 'Crawling the Web with the New Symfony Components', 'Adding Event Sourcing to an existing PHP project (for the right reasons)']],
            'day1_slot2' => ['11/21/19 11:32', ['Lunch']],
            'day2_slot1' => ['11/22/19 10:08', ['Break ☕ 🥐']],
            'day2_closing' => ['11/22/19 16:57', []],
        ];
    }
}
