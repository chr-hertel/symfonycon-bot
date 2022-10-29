<?php

declare(strict_types=1);

namespace App\Entity;

enum Track: string
{
    case SymfonyRoom = 'The Symfony room';
    case FrameworkRoom = 'The Framework room';
    case PlatformRoom = 'The Platform.sh room';
}
