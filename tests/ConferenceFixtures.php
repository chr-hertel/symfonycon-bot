<?php

declare(strict_types=1);

namespace App\Tests;

use App\DataFixtures\AppFixtures;

trait ConferenceFixtures
{
    use TestDatabase {
        setUp as dataBaseSetUp;
    }

    protected function setUp(): void
    {
        $this->dataBaseSetUp();

        $fixtures = new AppFixtures();
        $fixtures->load($this->entityManager);
    }
}
