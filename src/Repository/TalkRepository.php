<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Talk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Keiko\Uuid\Shortener\Exception\DictionaryException;
use Keiko\Uuid\Shortener\Shortener;

/**
 * @extends ServiceEntityRepository<Talk>
 */
final class TalkRepository extends ServiceEntityRepository
{
    public function __construct(private readonly Shortener $shortener, ManagerRegistry $registry)
    {
        parent::__construct($registry, Talk::class);
    }

    public function findByShortId(string $shortId): ?Talk
    {
        try {
            return $this->find($this->shortener->expand($shortId));
        } catch (DictionaryException) {
            return null;
        }
    }
}
