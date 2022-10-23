<?php

declare(strict_types=1);

namespace App\SymfonyCon;

use App\Entity\Slot;

/**
 * @extends \ArrayIterator<int, Slot>
 */
class SlotCollection extends \ArrayIterator
{
    private function __construct(Slot ...$slots)
    {
        parent::__construct(array_values($slots));
    }

    /**
     * @param array<Slot> $slots
     */
    public static function array(array $slots): self
    {
        return new self(...$slots);
    }

    public static function empty(): self
    {
        return new self();
    }

    /**
     * @phpstan-return array<int, list<Slot>>
     */
    public function inGroups(): array
    {
        $groups = [];
        /** @var Slot $slot */
        foreach ($this->getArrayCopy() as $slot) {
            $startDate = $slot->getStart()->format('U');
            if (!array_key_exists($startDate, $groups)) {
                $groups[$startDate] = [];
            }

            $groups[$startDate][] = $slot;
        }

        return $groups;
    }
}
