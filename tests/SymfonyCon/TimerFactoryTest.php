<?php

declare(strict_types=1);

namespace App\Tests\SymfonyCon;

use App\SymfonyCon\TimerFactory;
use App\Tests\ConferenceFixtures;
use App\Tests\SchemaSetup;
use App\Tests\TestDatabase;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Clock\MockClock;

final class TimerFactoryTest extends TestCase
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

    public function testCreateTimer(): void
    {
        $clock = new MockClock('11/18/19 19:15');
        $factory = new TimerFactory($this->repository, $clock);
        $timer = $factory->createTimer();
        $countdown = $timer->getCountdown();

        self::assertSame(2, $countdown->days);
        self::assertSame(12, $countdown->h);
        self::assertSame(45, $countdown->i);
    }
}
