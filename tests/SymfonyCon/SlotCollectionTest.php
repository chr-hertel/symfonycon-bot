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

        $collection = SlotCollection::array([$slot1, $slot2]);

        $expectedText = <<<TEXT
        *11/21 - 09:00-10:25*
        
        *Talk 1*
        
        *Talk 2*
        TEXT;

        static::assertSame($expectedText, (string) $collection);
    }
}
