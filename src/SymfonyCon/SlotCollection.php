<?php

declare(strict_types=1);

namespace App\SymfonyCon;

use App\Entity\Slot;

class SlotCollection extends \ArrayIterator
{
    private function __construct(Slot ...$slots)
    {
        parent::__construct($slots);
    }

    public static function array(array $slots): self
    {
        return new self(...$slots);
    }

    public static function empty(): self
    {
        return new self();
    }

    public function __toString(): string
    {
        if (0 === $this->count()) {
            return 'nothing found';
        }

        $text = sprintf('*%s-%s*', $this->getStart()->format('m/d - H:i'), $this->getEnd()->format('H:i'));

        foreach ($this->getArrayCopy() as $slot) {
            $text .= PHP_EOL.PHP_EOL.$slot;
        }

        return $text;
    }

    private function getStart(): \DateTimeImmutable
    {
        return array_reduce($this->getArrayCopy(), static function (?\DateTimeImmutable $carry, Slot $slot) {
            $start = $slot->getStart();

            if (null === $carry || $start < $carry) {
                return $start;
            }

            return $carry;
        });
    }

    private function getEnd(): \DateTimeImmutable
    {
        return array_reduce($this->getArrayCopy(), static function (?\DateTimeImmutable $carry, Slot $slot) {
            $end = $slot->getEnd();

            if (null === $carry || $end > $carry) {
                return $end;
            }

            return $carry;
        });
    }
}
