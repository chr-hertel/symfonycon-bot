<?php

declare(strict_types=1);

namespace App\Tests;

use Doctrine\ORM\Tools\SchemaTool;

trait SchemaSetup
{
    protected function setUpSchema(): void
    {
        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->updateSchema($this->entityManager->getMetadataFactory()->getAllMetadata());
    }
}
