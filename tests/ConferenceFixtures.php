<?php

declare(strict_types=1);

namespace App\Tests;

use App\DataFixtures\AppFixtures;

trait ConferenceFixtures
{
    protected function setUpFixtures(): void
    {
        $fixtures = new AppFixtures();
        $fixtures->load($this->entityManager);
    }
}
