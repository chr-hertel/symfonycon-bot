<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\TimeSpan;
use PHPUnit\Framework\TestCase;

final class TimeSpanTest extends TestCase
{
    public function testGetStart(): void
    {
        $start = new \DateTimeImmutable('2020-11-21 09:10', new \DateTimeZone('Europe/Paris'));
        $end = new \DateTimeImmutable('2020-11-21 09:55', new \DateTimeZone('Europe/Paris'));
        $timeSpan = new TimeSpan($start, $end);

        self::assertEquals($start, $timeSpan->getStart());
    }

    public function testGetEnd(): void
    {
        $start = new \DateTimeImmutable('2020-11-21 09:10', new \DateTimeZone('Europe/Paris'));
        $end = new \DateTimeImmutable('2020-11-21 09:55', new \DateTimeZone('Europe/Paris'));
        $timeSpan = new TimeSpan($start, $end);

        self::assertEquals($end, $timeSpan->getEnd());
    }

    public function testEndBeforeEndInvalid(): void
    {
        self::expectException(\InvalidArgumentException::class);
        self::expectDeprecationMessage('The time span needs to start before it ends.');

        $start = new \DateTimeImmutable('2020-11-21 07:10');
        $end = new \DateTimeImmutable('2020-11-21 06:55');
        new TimeSpan($start, $end);
    }

    public function testEnforcingParisTimeZone(): void
    {
        $start = new \DateTimeImmutable('2020-11-21 07:10');
        $end = new \DateTimeImmutable('2020-11-21 09:55', new \DateTimeZone('Europe/Helsinki'));
        $timeSpan = new TimeSpan($start, $end);

        $expectedStart = new \DateTimeImmutable('2020-11-21 08:10', new \DateTimeZone('Europe/Paris'));
        $expectedEnd = new \DateTimeImmutable('2020-11-21 08:55', new \DateTimeZone('Europe/Paris'));

        self::assertEquals($expectedStart, $timeSpan->getStart());
        self::assertEquals($expectedEnd, $timeSpan->getEnd());
    }

    public function testToString(): void
    {
        $start = new \DateTimeImmutable('2020-11-21 09:10', new \DateTimeZone('Europe/Paris'));
        $end = new \DateTimeImmutable('2020-11-21 09:55', new \DateTimeZone('Europe/Paris'));
        $timeSpan = new TimeSpan($start, $end);

        self::assertSame('Nov 21: 09:10 - 09:55', $timeSpan->toString());
    }
}
