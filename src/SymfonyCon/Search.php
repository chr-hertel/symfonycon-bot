<?php

declare(strict_types=1);

namespace App\SymfonyCon;

use Algolia\SearchBundle\SearchService;
use App\Entity\Slot;
use Doctrine\ORM\EntityManagerInterface;

class Search
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SearchService $searchService,
    ) {
    }

    public function search(string $query): SlotCollection
    {
        /** @var Slot[] $slots */
        $slots = $this->searchService->search($this->entityManager, Slot::class, $query);

        return SlotCollection::array($slots);
    }
}
