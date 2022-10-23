<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Slot;
use PHPUnit\Framework\TestCase;

final class SlotTest extends TestCase
{
    public function testSlotText(): void
    {
        $start = new \DateTimeImmutable('11/21/19 10:05');
        $end = new \DateTimeImmutable('11/21/19 10:45');
        $slot = new Slot('Talk 1', $start, $end, 'Speaker Name', 'Advanced');

        $expectedText = <<<TEXT
        Nov 21: 10:05 - 10:45
        Advanced
        
        *Talk 1*
        _Speaker Name_
        TEXT;

        static::assertSame($expectedText, (string) $slot);
    }

    public function testSlotTextWithoutTrack(): void
    {
        $start = new \DateTimeImmutable('11/21/19 10:05');
        $end = new \DateTimeImmutable('11/21/19 10:45');
        $slot = new Slot('Keynote', $start, $end, 'Speaker Name');

        $expectedText = <<<TEXT
        Nov 21: 10:05 - 10:45
        
        *Keynote*
        _Speaker Name_
        TEXT;

        static::assertSame($expectedText, (string) $slot);
    }

    public function testSlotTextWithoutTrackAndSpeaker(): void
    {
        $start = new \DateTimeImmutable('11/21/19 10:05');
        $end = new \DateTimeImmutable('11/21/19 10:45');
        $slot = new Slot('Lunch', $start, $end);

        $expectedText = <<<TEXT
        Nov 21: 10:05 - 10:45
        
        *Lunch*
        TEXT;

        static::assertSame($expectedText, (string) $slot);
    }
}
