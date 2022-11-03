<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Slot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Keiko\Uuid\Shortener\Exception\DictionaryException;
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

    public function findByShortId(string $shortId): ?Slot
    {
        try {
            return $this->find($this->shortener->expand($shortId));
        } catch (DictionaryException) {
            return null;
        }
    }

    /**
     * @return Slot[]
     */
    public function findByDay(\DateTimeImmutable $date): array
    {
        $day = $date->format('Y-m-d');

        $queryBuilder = $this->createQueryBuilder('s');
        $query = $queryBuilder
            ->where($queryBuilder->expr()->like('s.timeSpan.start', ':start'))
            ->setParameter('start', sprintf('%s%%', $day))
            ->orderBy('s.timeSpan.start', 'ASC')
            ->getQuery()
            ->enableResultCache(3600, sprintf('schedule-%s', $day));

        return $query->getResult();
    }

    public function findByTime(\DateTimeImmutable $time): ?Slot
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $query = $queryBuilder
            ->where($queryBuilder->expr()->between(':time', 's.timeSpan.start', 's.timeSpan.end'))
            ->setParameter('time', $time)
            ->getQuery();

        try {
            return $query->getSingleResult();
        } catch (NoResultException) {
            return null;
        }
    }

    public function findFirst(): ?Slot
    {
        return $this->findOneBy([], ['timeSpan.start' => 'ASC']);
    }

    /**
     * @phpstan-return array{start: \DateTimeImmutable, end: \DateTimeImmutable}
     */
    public function getTimeSpan(): array
    {
        return $this->createQueryBuilder('s')
            ->select('new DateTimeImmutable(min(s.timeSpan.start)) as start')
            ->addSelect('new DateTimeImmutable(max(s.timeSpan.end)) as end')
            ->getQuery()
            ->getSingleResult();
    }
}
