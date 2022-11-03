<?php

declare(strict_types=1);

namespace App\Tests;

use Keiko\Uuid\Shortener\Dictionary;
use Keiko\Uuid\Shortener\Shortener;

trait UuidShortener
{
    protected function createShortener(): Shortener
    {
        return Shortener::make(Dictionary::createUnmistakable());
    }
}
