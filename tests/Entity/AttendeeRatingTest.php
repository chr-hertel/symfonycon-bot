<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\AttendeeRating;
use App\Entity\Rating;
use App\Entity\Slot;
use App\Entity\Talk;
use App\Entity\TimeSpan;
use App\Entity\Track;
use PHPUnit\Framework\TestCase;

final class AttendeeRatingTest extends TestCase
{
    public function testConstruct(): void
    {
        $start = new \DateTimeImmutable('12.12.2012 12:12');
        $timeSpan = new TimeSpan($start, $start->modify('+45 minutes'));
        $talk = new Talk('Working with events', 'John Doe', 'This is a dummy', $timeSpan, Track::SymfonyRoom, new Slot($timeSpan));
        $rating = new AttendeeRating($talk, 1234567890, Rating::TwoStars);

        self::assertSame($talk, $rating->getTalk());
        self::assertSame(1234567890, $rating->getAttendee());
        self::assertSame(Rating::TwoStars, $rating->getRating());
    }
}
