<?php

declare(strict_types=1);

namespace App\Tests\SymfonyCon;

use App\Entity\Slot;
use App\SymfonyCon\SlotCollection;
use PHPUnit\Framework\TestCase;

class SlotCollectionTest extends TestCase
{
    public function testSlotsWithMultipleTimes(): void
    {
        $slot1 = new Slot('Talk 1', new \DateTimeImmutable('11/21/19 09:00'), new \DateTimeImmutable('11/21/19 09:40'));
        $slot2 = new Slot('Talk 2', new \DateTimeImmutable('11/21/19 09:45'), new \DateTimeImmutable('11/21/19 10:25'));
        $slot3 = new Slot('Talk 3', new \DateTimeImmutable('11/21/19 10:30'), new \DateTimeImmutable('11/21/19 11:15'));

        $collection = SlotCollection::array([$slot1, $slot2, $slot3]);

        $expectedText = <<<TEXT
        *11/21 - 09:00-11:15*
        
        09:00-09:40
        *Talk 1*
        
        09:45-10:25
        *Talk 2*
        
        10:30-11:15
        *Talk 3*
        TEXT;

        static::assertSame($expectedText, (string) $collection);
    }

    public function testEmptyCollection(): void
    {
        $collection = SlotCollection::empty();

        static::assertCount(0, $collection);
        static::assertSame('nothing found', (string) $collection);
    }
}
