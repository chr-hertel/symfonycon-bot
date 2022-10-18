<?php

declare(strict_types=1);

namespace App\Tests\SymfonyCon;

use App\SymfonyCon\TimerFactory;
use App\Tests\ConferenceFixtures;
use PHPUnit\Framework\TestCase;

final class TimerFactoryTest extends TestCase
{
    use ConferenceFixtures;

    public function testCreateTimer(): void
    {
        $factory = new TimerFactory($this->repository, '11/18/19 19:15');
        $timer = $factory->createTimer();
        $countdown = $timer->getCountdown();

        static::assertSame(2, $countdown->days);
        static::assertSame(12, $countdown->h);
        static::assertSame(45, $countdown->i);
    }
}
