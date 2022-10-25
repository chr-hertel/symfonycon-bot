<?php

declare(strict_types=1);

namespace App\Twig;

use Keiko\Uuid\Shortener\Shortener;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class ShortExtension extends AbstractExtension
{
    public function __construct(private readonly Shortener $shortener)
    {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('short', [$this->shortener, 'reduce']),
        ];
    }
}
