<?php

declare(strict_types=1);

namespace App\Tests;

use App\ChatBot\Replier\Renderer\DayRenderer;
use App\ChatBot\Replier\Renderer\SlotRenderer;
use Keiko\Uuid\Shortener\Dictionary;
use Keiko\Uuid\Shortener\Shortener;

trait Renderer
{
    private DayRenderer $dayRenderer;
    private SlotRenderer $slotRenderer;

    protected function setUpDayRenderer(): void
    {
        $this->dayRenderer = new DayRenderer($this->createShortener());
    }

    protected function setUpSlotRenderer(): void
    {
        $this->slotRenderer = new SlotRenderer($this->createShortener());
    }

    private function createShortener(): Shortener
    {
        return Shortener::make(Dictionary::createUnmistakable());
    }
}
