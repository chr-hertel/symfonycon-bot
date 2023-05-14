<?php

declare(strict_types=1);

namespace App\Tests\SymfonyCon\Crawler;

use App\Entity\Event;
use App\Entity\Slot;
use App\Entity\Talk;
use App\Entity\TimeSpan;
use App\Entity\Track;
use App\SymfonyCon\Crawler\Parser;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class ParserTest extends TestCase
{
    public function testSlotCollectionHasTheCorrectAmountOfSlots(): void
    {
        $parser = new Parser();
        $response = (string) file_get_contents(dirname(__DIR__).'/fixtures/full-schedule.html');

        $slots = $parser->extractSlots($response);

        self::assertCount(27, $slots);
    }

    /**
     * @param list<Slot> $expectedSlot
     */
    #[DataProvider('provideSnippetsAndSlots')]
    public function testSlotExtractionWithData(string $fileName, array $expectedSlot): void
    {
        $parser = new Parser();
        $snippet = (string) file_get_contents($fileName);

        $actualSlots = $parser->extractSlots($snippet);

        self::assertSameCollection($expectedSlot, $actualSlots);
    }

    /**
     * @return iterable<string, array{string, list<Slot>}>
     */
    public static function provideSnippetsAndSlots(): iterable
    {
        $timeSpan = new TimeSpan(new \DateTimeImmutable('17-11-2022 08:15'), new \DateTimeImmutable('17-11-2022 08:55'));
        $slot = new Slot($timeSpan);
        $slot->addEvent(new Talk('Keynote', 'Fabien Potencier', '', $timeSpan, Track::SymfonyRoom, $slot));
        yield 'keynote' => [
            dirname(__DIR__).'/fixtures/keynote.html', [$slot],
        ];

        $timeSpan = new TimeSpan(new \DateTimeImmutable('18-11-2022 11:20'), new \DateTimeImmutable('18-11-2022 13:30'));
        $slot = new Slot($timeSpan);
        $slot->addEvent(new Event('Lunch 🍽', $timeSpan, $slot));
        yield 'lunch' => [
            dirname(__DIR__).'/fixtures/lunch.html', [$slot],
        ];

        $timeSpan = new TimeSpan(new \DateTimeImmutable('17-11-2022 10:10'), new \DateTimeImmutable('17-11-2022 10:45'));
        $slot = new Slot($timeSpan);
        $slot->addEvent(new Talk('Unleashing the power of lazy objects in PHP 🪄', 'Nicolas Grekas', '', $timeSpan, Track::SymfonyRoom, $slot));
        $slot->addEvent(new Talk('Transactional vs. Analytical Processing', 'Christopher Hertel', '', $timeSpan, Track::FrameworkRoom, $slot));
        yield 'two-talks' => [
            dirname(__DIR__).'/fixtures/two-talks.html', [$slot],
        ];

        $timeSpan = new TimeSpan(new \DateTimeImmutable('18-11-2022 10:00'), new \DateTimeImmutable('18-11-2022 10:35'));
        $slot = new Slot($timeSpan);
        $slot->addEvent(new Talk('Advanced Test Driven Development', 'Diego Aguiar', '', $timeSpan, Track::SymfonyRoom, $slot));
        $slot->addEvent(new Talk('How to handle content editing in Symfony', 'Titouan Galopin', '', $timeSpan, Track::FrameworkRoom, $slot));
        $slot->addEvent(new Talk('What is FleetOps and why you should care?', 'Jessica Orozco', '', $timeSpan, Track::PlatformRoom, $slot));
        yield 'three-talks' => [
            dirname(__DIR__).'/fixtures/three-talks.html', [$slot],
        ];

        $timeSpan1 = new TimeSpan(new \DateTimeImmutable('17-11-2022 13:30'), new \DateTimeImmutable('17-11-2022 14:05'));
        $slot1 = new Slot($timeSpan1);
        $slot1->addEvent(new Talk('PHPStan: Advanced Types', 'Ondřej Mirtes', '', $timeSpan1, Track::SymfonyRoom, $slot1));
        $slot1->addEvent(new Talk('Schrödinger\'s SQL - The SQL inside the Doctrine box', 'Claudio Zizza', '', $timeSpan1, Track::FrameworkRoom, $slot1));
        $slot1->addEvent(new Talk('Build apps, not platforms: operational maturity in a box', 'Ori Pekelman', '', $timeSpan1, Track::PlatformRoom, $slot1));
        $timeSpan2 = new TimeSpan(new \DateTimeImmutable('17-11-2022 14:15'), new \DateTimeImmutable('17-11-2022 14:50'));
        $slot2 = new Slot($timeSpan2);
        $slot2->addEvent(new Talk('The PHP Stack’s Supply Chain', 'Sebastian Bergmann', '', $timeSpan2, Track::SymfonyRoom, $slot2));
        $slot2->addEvent(new Talk('Symfony & Hotwire: an efficient combo to quickly develop complex applications', 'Florent Destremau', '', $timeSpan2, Track::FrameworkRoom, $slot2));
        $slot2->addEvent(new Talk('Building a great product means designing for your users.', 'Natalie Harper', '', $timeSpan2, Track::PlatformRoom, $slot2));
        yield 'two-rows' => [
            dirname(__DIR__).'/fixtures/two-rows.html', [$slot1, $slot2],
        ];
    }

    public function testExtractingDescription(): void
    {
        $parser = new Parser();
        $response = (string) file_get_contents(dirname(__DIR__).'/fixtures/full-schedule.html');

        $expectedDescription = 'We all love Disney movies, right? They are entertaining, trigger emotional response but also contain a lot of important lessons. And these lessons can also be applied to your career as a developer. During this talk I\'ll have a look at 7 situations from some of my favorite Disney movies to analyze and see what lesson we can learn from that.';
        $actualDescription = '';

        $slots = $parser->extractSlots($response);
        foreach ($slots as $slot) {
            foreach ($slot->getEvents() as $event) {
                if ('7 Lessons You Can Learn From Disney Movies' === $event->getTitle()) {
                    self::assertInstanceOf(Talk::class, $event);
                    $actualDescription = $event->getDescription();
                }
            }
        }

        self::assertSame($expectedDescription, $actualDescription);
    }

    /**
     * @param list<Slot> $expected
     * @param list<Slot> $actual
     */
    private static function assertSameCollection(array $expected, array $actual): void
    {
        self::assertSameSize($expected, $actual);

        foreach ($actual as $i => $slot) {
            self::assertArrayHasKey($i, $expected);
            self::assertSame($expected[$i]->getEvents()[0]->getTitle(), $slot->getEvents()[0]->getTitle());
            self::assertEquals($expected[$i]->getTimeSpan(), $slot->getTimeSpan());
        }
    }
}
