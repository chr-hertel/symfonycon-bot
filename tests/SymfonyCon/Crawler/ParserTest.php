<?php

declare(strict_types=1);

namespace App\Tests\SymfonyCon\Crawler;

use App\Entity\Slot;
use App\SymfonyCon\Crawler\Parser;
use App\SymfonyCon\SlotCollection;
use PHPUnit\Framework\TestCase;

final class ParserTest extends TestCase
{
    public function testSlotCollectionHasTheCorrectAmountOfSlots(): void
    {
        $parser = new Parser();
        $response = (string) file_get_contents(dirname(__DIR__).'/fixtures/full-schedule.html');

        $slotCollection = $parser->extractSlots($response);

        static::assertCount(45, $slotCollection);
    }

    /**
     * @dataProvider provideSnippetsAndSlots
     *
     * @phpstan-param list<Slot> $slots
     */
    public function testSlotExtractionWithData(string $fileName, array $slots): void
    {
        $parser = new Parser();
        $snippet = (string) file_get_contents($fileName);
        $expectedSlotCollection = SlotCollection::array($slots);

        $actualSlotCollection = $parser->extractSlots($snippet);

        static::assertSame((string) $expectedSlotCollection, (string) $actualSlotCollection);
    }

    /**
     * @phpstan-return iterable<string, array{string, list<Slot>}>
     */
    public function provideSnippetsAndSlots(): iterable
    {
        yield 'keynote' => [
            dirname(__DIR__).'/fixtures/keynote.html',
            [
                new Slot('Keynote', new \DateTimeImmutable('17-11-2022 08:15'), new \DateTimeImmutable('17-11-2022 08:55'), 'Fabien Potencier'),
            ],
        ];

        yield 'lunch' => [
            dirname(__DIR__).'/fixtures/lunch.html',
            [
                new Slot('Lunch 🍽', new \DateTimeImmutable('18-11-2022 11:20'), new \DateTimeImmutable('18-11-2022 13:30')),
            ],
        ];

        yield 'two-talks' => [
            dirname(__DIR__).'/fixtures/two-talks.html',
            [
                new Slot('Unleashing the power of lazy objects in PHP 🪄', new \DateTimeImmutable('17-11-2022 10:10'), new \DateTimeImmutable('17-11-2022 10:45'), 'Nicolas Grekas', 'The Symfony room'),
                new Slot('Transactional vs. Analytical Processing', new \DateTimeImmutable('17-11-2022 10:10'), new \DateTimeImmutable('17-11-2022 10:45'), 'Christopher Hertel', 'The Framework room'),
            ],
        ];

        yield 'three-talks' => [
            dirname(__DIR__).'/fixtures/three-talks.html',
            [
                new Slot('Advanced Test Driven Development', new \DateTimeImmutable('18-11-2022 10:00'), new \DateTimeImmutable('18-11-2022 10:35'), 'Diego Aguiar', 'The Symfony room'),
                new Slot('How to handle content editing in Symfony', new \DateTimeImmutable('18-11-2022 10:00'), new \DateTimeImmutable('18-11-2022 10:35'), 'Titouan Galopin', 'The Framework room'),
                new Slot('What is FleetOps and why you should care?', new \DateTimeImmutable('18-11-2022 10:00'), new \DateTimeImmutable('18-11-2022 10:35'), 'Jessica Orozco', 'The Platform.sh room'),
            ],
        ];

        yield 'two-rows' => [
            dirname(__DIR__).'/fixtures/two-rows.html',
            [
                new Slot('PHPStan: Advanced Types', new \DateTimeImmutable('17-11-2022 13:30'), new \DateTimeImmutable('17-11-2022 14:05'), 'Ondřej Mirtes', 'The Symfony room'),
                new Slot('Schrödinger\'s SQL - The SQL inside the Doctrine box', new \DateTimeImmutable('17-11-2022 13:30'), new \DateTimeImmutable('17-11-2022 14:05'), 'Claudio Zizza', 'The Framework room'),
                new Slot('Build apps, not platforms: operational maturity in a box', new \DateTimeImmutable('17-11-2022 13:30'), new \DateTimeImmutable('17-11-2022 14:05'), 'Ori Pekelman', 'The Platform.sh room'),
                new Slot('The PHP Stack’s Supply Chain', new \DateTimeImmutable('17-11-2022 14:15'), new \DateTimeImmutable('17-11-2022 14:50'), 'Sebastian Bergmann', 'The Symfony room'),
                new Slot('Symfony & Hotwire: an efficient combo to quickly develop complex applications', new \DateTimeImmutable('17-11-2022 14:15'), new \DateTimeImmutable('17-11-2022 14:50'), 'Florent Destremau', 'The Framework room'),
                new Slot('Building a great product means designing for your users.', new \DateTimeImmutable('17-11-2022 14:15'), new \DateTimeImmutable('17-11-2022 14:50'), 'Natalie Harper', 'The Platform.sh room'),
            ],
        ];
    }

    public function testExtractingDescription(): void
    {
        $parser = new Parser();
        $response = (string) file_get_contents(dirname(__DIR__).'/fixtures/full-schedule.html');

        $expectedDescription = 'We all love Disney movies, right? They are entertaining, trigger emotional response but also contain a lot of important lessons. And these lessons can also be applied to your career as a developer. During this talk I\'ll have a look at 7 situations from some of my favorite Disney movies to analyze and see what lesson we can learn from that.';
        $actualDescription = '';

        $slotCollection = $parser->extractSlots($response);
        foreach ($slotCollection as $slot) {
            if ('7 Lessons You Can Learn From Disney Movies' === $slot->getTitle()) {
                $actualDescription = $slot->getDescription();
            }
        }

        static::assertSame($expectedDescription, $actualDescription);
    }
}
