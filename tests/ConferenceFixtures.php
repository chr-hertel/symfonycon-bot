<?php

declare(strict_types=1);

namespace App\Tests;

use App\DataFixtures\AppFixtures;
use App\Repository\SlotRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\DependencyInjection\Container;

trait ConferenceFixtures
{
    private Cache $resultCache;
    private SlotRepository $repository;

    protected function setUp(): void
    {
        $this->resultCache = DoctrineProvider::wrap(new ArrayAdapter());

        $config = $this->createConfiguration();

        $params = [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ];
        $entityManager = EntityManager::create($params, $config);

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

    private function createConfiguration(): Configuration
    {
        $config = new Configuration();
        $config->setEntityNamespaces(['SymfonyTestsDoctrine' => 'Symfony\Bridge\Doctrine\Tests\Fixtures']);
        $config->setAutoGenerateProxyClasses(true);
        $config->setProxyDir(sys_get_temp_dir());
        $config->setProxyNamespace('SymfonyTests\Doctrine');
        $config->setMetadataDriverImpl(new AttributeDriver([__DIR__.'/../src/Entity']));
        $config->setResultCacheImpl($this->resultCache);

        return $config;
    }
}
