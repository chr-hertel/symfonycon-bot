<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Slot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Keiko\Uuid\Shortener\Shortener;

/**
 * @extends ServiceEntityRepository<Slot>
 */
final class SlotRepository extends ServiceEntityRepository
{
    public function __construct(private readonly Shortener $shortener, ManagerRegistry $registry)
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
            ->orderBy('s.start', 'ASC')
            ->getQuery()
            ->enableResultCache(3600, sprintf('schedule-%s', $day));

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

    public function findByShortId(string $shortId): Slot|null
    {
        return $this->find($this->shortener->expand($shortId));
    }

    /**
     * @phpstan-return array{start: \DateTimeImmutable, end: \DateTimeImmutable}
     */
    public function getTimeSpan(): array
    {
        return $this->createQueryBuilder('s')
            ->select('new DateTimeImmutable(min(s.start)) as start')
            ->addSelect('new DateTimeImmutable(max(s.end)) as end')
            ->getQuery()
            ->getSingleResult();
    }
}
