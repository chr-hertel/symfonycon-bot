<?php

declare(strict_types=1);

namespace App\Entity;

enum Rating: int
{
    case OneStar = 1;
    case TwoStars = 2;
    case ThreeStars = 3;
}
