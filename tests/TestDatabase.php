<?php

declare(strict_types=1);

namespace App\Tests;

use App\Repository\SlotRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\DependencyInjection\Container;

trait TestDatabase
{
    use UuidShortener;

    private CacheItemPoolInterface $resultCache;
    private EntityManagerInterface $entityManager;
    private SlotRepository $repository;

    protected function setUpDatabase(): void
    {
        $this->resultCache = new ArrayAdapter();

        $config = $this->createConfiguration();

        $params = [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ];
        $this->entityManager = EntityManager::create($params, $config);

        $container = new Container();
        $container->set('connection', $this->entityManager->getConnection());
        $container->set('entity_manager', $this->entityManager);
        $registry = new Registry($container, ['connection'], ['entity_manager'], 'connection', 'entity_manager');
        $this->repository = new SlotRepository($this->createShortener(), $registry);
    }

    private function createConfiguration(): Configuration
    {
        $config = new Configuration();
        $config->setEntityNamespaces(['SymfonyTestsDoctrine' => 'Symfony\Bridge\Doctrine\Tests\Fixtures']);
        $config->setAutoGenerateProxyClasses(true);
        $config->setProxyDir(sys_get_temp_dir());
        $config->setProxyNamespace('SymfonyTests\Doctrine');
        $config->setMetadataDriverImpl(new AttributeDriver([__DIR__.'/../src/Entity']));
        $config->setResultCache($this->resultCache);

        return $config;
    }
}
