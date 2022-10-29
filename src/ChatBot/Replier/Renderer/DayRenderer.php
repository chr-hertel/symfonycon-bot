<?php

declare(strict_types=1);

namespace App\ChatBot\Replier\Renderer;

use App\Entity\Slot;
use App\Entity\Talk;
use Keiko\Uuid\Shortener\Shortener;

class DayRenderer
{
    public function __construct(private readonly Shortener $shortener)
    {
    }

    /**
     * @param list<Slot> $slots
     */
    public function render(string $headline, array $slots): string
    {
        $slot = reset($slots);

        if (false === $slot) {
            return '<b>'.$headline.'</b>'.PHP_EOL.PHP_EOL.'<i>Nothing found.</i>';
        }

        $message = '<b>'.$headline.'</b> ('.$slot->getTimeSpan()->getEnd()->format('M d').')';
        $message .= PHP_EOL.PHP_EOL;

        foreach ($slots as $slot) {
            $message .= sprintf('___ %s - %s _______',
                $slot->getTimeSpan()->getStart()->format('H:i'),
                $slot->getTimeSpan()->getEnd()->format('H:i'),
            );
            $message .= PHP_EOL.PHP_EOL;

            foreach ($slot->getEvents() as $event) {
                if ($event instanceof Talk) {
                    $message .= '<i>'.$event->getTrack().'</i>'.PHP_EOL;
                }
                $message .= '<b>'.$event->getTitle().'</b>'.PHP_EOL;
                if ($event instanceof Talk) {
                    $message .= '» /talk@'.$this->shortener->reduce($event->getId()).PHP_EOL;
                }
                $message .= PHP_EOL;
            }
        }

        return $message;
    }
}
