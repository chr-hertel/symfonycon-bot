<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Slot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SlotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Slot::class);
    }

    /**
     * @return Slot[]
     */
    public function findByDay(\DateTimeImmutable $date): array
    {
        $day = $date->format('Y-m-d');

        $queryBuilder = $this->createQueryBuilder('s');
        $query = $queryBuilder
            ->where($queryBuilder->expr()->like('s.start', ':start'))
            ->setParameter('start', sprintf('%s%%', $day))
            ->getQuery()
            ->useResultCache(true, 3600, sprintf('schedule-%s', $day));

        return $query->getResult();
    }

    /**
     * @return Slot[]
     */
    public function findByTime(\DateTimeImmutable $time): array
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $query = $queryBuilder
            ->where($queryBuilder->expr()->between(':time', 's.start', 's.end'))
            ->setParameter('time', $time)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @return Slot[]
     */
    public function findNext(\DateTimeImmutable $time): array
    {
        $subQueryBuilder = $this->createQueryBuilder('s');
        $subQuery = $subQueryBuilder
            ->select('min(s.start)')
            ->where($subQueryBuilder->expr()->gte('s.start', ':time'))
            ->getQuery();

        $queryBuilder = $this->createQueryBuilder('slot');
        $query = $queryBuilder
            ->where($queryBuilder->expr()->eq('slot.start', sprintf('(%s)', $subQuery->getDQL())))
            ->getQuery();

        return $query
            ->setParameter('time', $time)
            ->getResult();
    }
}
