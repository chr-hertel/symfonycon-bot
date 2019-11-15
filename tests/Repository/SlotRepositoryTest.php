<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\DataFixtures\AppFixtures;
use App\Entity\Slot;
use App\Repository\SlotRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Persistence\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Doctrine\Test\DoctrineTestHelper;
use Symfony\Component\DependencyInjection\Container;

class SlotRepositoryTest extends TestCase
{
    private $resultCache;
    private $repository;

    /**
     * @dataProvider provideDays
     */
    public function testFindByDay(string $date, int $expectedCount, string $cacheKey): void
    {
        $dateTime = new \DateTimeImmutable($date);
        $slots = $this->repository->findByDay($dateTime);

        static::assertCount($expectedCount, array_filter($slots, static function (Slot $slot) use ($dateTime) {
            $dayStart = $dateTime->modify('midnight');
            $dayEnd = $dateTime->modify('midnight +1 day');
            $start = $slot->getStart();

            return $dayStart < $start && $start < $dayEnd;
        }));
        static::assertTrue($this->resultCache->contains($cacheKey));
    }

    public function provideDays(): array
    {
        return [
            'day1' => ['11/21/19 08:00', 23, 'schedule-2019-11-21'],
            'day2' => ['11/22/19 17:00', 22, 'schedule-2019-11-22'],
        ];
    }

    /**
     * @dataProvider provideTimes
     */
    public function testFindByTime(string $time, array $titles): void
    {
        $slots = $this->repository->findByTime(new \DateTimeImmutable($time));

        static::assertCount(count($titles), $slots);
        foreach ($slots as $i => $slot) {
            static::assertSame($titles[$i], $slot->getTitle());
        }
    }

    public function provideTimes(): array
    {
        return [
            'day1_keynote' => ['11/21/19 09:36', ['Keynote']],
            'day1_lunch' => ['11/21/19 13:15', ['Lunch']],
            'day1_slot2' => ['11/21/19 11:32', ['How Doctrine caching can skyrocket your application', 'Evolving with Symfony in a long-term project', 'Crazy Fun Experiments with PHP (Not for Production)']],
            'day2_slot1' => ['11/22/19 10:08', ['Using API Platform to build ticketing system', 'Make the Most out of Twig', 'Mental Health in the Workplace']],
            'day2_closing' => ['11/22/19 16:57', ['Closing session']],
        ];
    }

    /**
     * @dataProvider provideNext
     */
    public function testFindNext(string $time, array $titles): void
    {
        $slots = $this->repository->findNext(new \DateTimeImmutable($time));

        static::assertCount(count($titles), $slots);
        foreach ($slots as $i => $slot) {
            static::assertSame($titles[$i], $slot->getTitle());
        }
    }

    public function provideNext(): array
    {
        return [
            'day1_keynote' => ['11/21/19 09:36', ['HTTP/3: It\'s all about the transport!', 'How to contribute to Symfony and why you should give it a try', 'A view in the PHP Virtual Machine']],
            'day1_lunch' => ['11/21/19 13:15', ['Hexagonal Architecture with Symfony', 'Crawling the Web with the New Symfony Components', 'Adding Event Sourcing to an existing PHP project (for the right reasons)']],
            'day1_slot2' => ['11/21/19 11:32', ['Lunch']],
            'day2_slot1' => ['11/22/19 10:08', ['Break ☕ 🥐']],
            'day2_closing' => ['11/22/19 16:57', []],
        ];
    }

    protected function setUp(): void
    {
        $config = DoctrineTestHelper::createTestConfiguration();
        $this->resultCache = new ArrayCache();
        $config->setResultCacheImpl($this->resultCache);
        /** @var AnnotationDriver $driver */
        $driver = $config->getMetadataDriverImpl();
        $driver->addPaths([__DIR__.'/../../src/Entity']);

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
