<?php

declare(strict_types=1);

namespace App\Tests;

use App\DataFixtures\AppFixtures;
use App\Repository\SlotRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Persistence\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bridge\Doctrine\Test\DoctrineTestHelper;
use Symfony\Component\DependencyInjection\Container;

trait ConferenceFixtures
{
    private Cache $resultCache;
    private SlotRepository $repository;

    protected function setUp(): void
    {
        $config = DoctrineTestHelper::createTestConfiguration();
        $this->resultCache = new ArrayCache();
        $config->setResultCacheImpl($this->resultCache);
        /** @var AnnotationDriver $driver */
        $driver = $config->getMetadataDriverImpl();
        $driver->addPaths([__DIR__.'/../src/Entity']);

        $entityManager = DoctrineTestHelper::createTestEntityManager($config);
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->createSchema($entityManager->getMetadataFactory()->getAllMetadata());

        $fixtures = new AppFixtures();
        $fixtures->load($entityManager);

        $container = new Container();
        $container->set('connection', $entityManager->getConnection());
        $container->set('entity_manager', $entityManager);
        $registry = new Registry($container, ['connection'], ['entity_manager'], 'connection', 'entity_manager');
        $this->repository = new SlotRepository($registry);
    }
}
