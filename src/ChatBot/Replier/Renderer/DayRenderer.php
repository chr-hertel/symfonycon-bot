<?php

declare(strict_types=1);

namespace App\ChatBot\Replier\Renderer;

use App\Entity\Slot;
use App\SymfonyCon\SlotCollection;
use Keiko\Uuid\Shortener\Shortener;

class DayRenderer
{
    public function __construct(private readonly Shortener $shortener)
    {
    }

    public function render(string $headline, SlotCollection $slots): string
    {
        $slot = $slots->current();

        if (!$slot instanceof Slot) {
            return '<b>'.$headline.'</b>'.PHP_EOL.PHP_EOL.'<i>Nothing found.</i>';
        }

        $message = '<b>'.$headline.'</b> ('.$slot->getStart()->format('M d').')';
        $message .= PHP_EOL.PHP_EOL;

        foreach ($slots->inGroups() as $group) {
            $first = reset($group);

            if (false === $first) {
                continue;
            }

            $message .= '__ '.$first->getStart()->format('H:i').' - '.$first->getEnd()->format('H:i').'_____';
            $message .= PHP_EOL.PHP_EOL;

            foreach ($group as $slot) {
                if (null !== $slot->getTrack()) {
                    $message .= '<i>'.$slot->getTrack().'</i>'.PHP_EOL;
                }
                $message .= '<b>'.$slot->getTitle().'</b>'.PHP_EOL;
                if (null !== $slot->getDescription()) {
                    $message .= '» /slot@'.$this->shortener->reduce($slot->getId()).PHP_EOL;
                }
                $message .= PHP_EOL;
            }
        }

        return $message;
    }
}
