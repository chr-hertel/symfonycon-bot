<?php

declare(strict_types=1);

namespace App\ChatBot\Replier\Renderer;

use App\Entity\Slot;
use App\Entity\Talk;
use Keiko\Uuid\Shortener\Shortener;

class SlotRenderer
{
    public function __construct(private readonly Shortener $shortener)
    {
    }

    public function render(string $headline, Slot $slot): string
    {
        $message = '<b>'.$headline.'</b> ('.$slot->getTimeSpan()->toString().')';
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

        return $message;
    }
}
