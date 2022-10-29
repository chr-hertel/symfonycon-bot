<?php

declare(strict_types=1);

namespace App\SymfonyCon;

use Algolia\SearchBundle\SearchService;
use App\Entity\Talk;
use Doctrine\ORM\EntityManagerInterface;

class Search
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SearchService $searchService,
    ) {
    }

    /**
     * @return list<Talk>
     */
    public function search(string $query): array
    {
        /** @var list<Talk> $talks */
        $talks = $this->searchService->search($this->entityManager, Talk::class, $query);

        return $talks;
    }
}
