<?php

declare(strict_types=1);

namespace App\ChatBot\Replier\Renderer;

use App\Entity\Slot;
use App\Entity\Talk;
use Keiko\Uuid\Shortener\Shortener;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\Button\InlineKeyboardButton;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\InlineKeyboardMarkup;

class SlotRenderer
{
    public function __construct(private readonly Shortener $shortener)
    {
    }

    public function buttons(Slot $slot): InlineKeyboardMarkup
    {
        $buttons = [];
        if (!$slot->isFirst()) {
            $buttons[] = (new InlineKeyboardButton('Previous Slot'))
                ->callbackData('/slot@'.$this->shortener->reduce($slot->getPrevious()->getId()));
        }
        if (!$slot->isLast()) {
            $buttons[] = (new InlineKeyboardButton('Next Slot'))
                ->callbackData('/slot@'.$this->shortener->reduce($slot->getNext()->getId()));
        }

        return (new InlineKeyboardMarkup())->inlineKeyboard($buttons);
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
