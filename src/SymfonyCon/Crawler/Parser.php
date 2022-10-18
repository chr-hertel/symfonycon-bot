<?php

declare(strict_types=1);

namespace App\SymfonyCon\Crawler;

use App\Entity\Slot;
use App\SymfonyCon\SlotCollection;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\DomCrawler\Crawler;

final class Parser
{
    private const TRACKS = [
        '0' => 'The Symfony room',
        '1' => 'The Framework room',
        '2' => 'The Platform.sh room',
    ];

    public function __construct(private readonly LoggerInterface $logger = new NullLogger())
    {
    }

    public function extractSlots(string $response): SlotCollection
    {
        $crawler = new Crawler($response);
        $slots = [];

        // Extract slots that are no talks
        $crawler->filter('.schedule-event')->each(function (Crawler $event) use (&$slots) {
            $title = $event->filter('.schedule-event-title')->text();
            $startsAt = $event->siblings()->filter('.schedule-time')->attr('data-starts-at');
            $endsAt = $event->siblings()->filter('.schedule-time')->attr('data-ends-at');

            if (null === $startsAt || null === $endsAt) {
                $this->logger->warning('Cannot collect start or end time for event', [
                    'title' => $title,
                    'startsAt' => $startsAt,
                    'endsAt' => $endsAt,
                ]);

                return;
            }

            $slots[] = new Slot(
                $event->filter('.schedule-event-title')->text(),
                new \DateTimeImmutable($startsAt),
                new \DateTimeImmutable($endsAt),
            );
        });

        // Extract talks per row
        $crawler->filter('.schedule-row')->each(function (Crawler $row) use (&$slots) {
            $row->filter('.schedule-talk')->each(function (Crawler $talk, int $index) use (&$slots) {
                $title = $talk->filter('.schedule-talk-title')->text();
                $startsAt = $talk->siblings()->filter('.schedule-time')->attr('data-starts-at');
                $endsAt = $talk->siblings()->filter('.schedule-time')->attr('data-ends-at');

                if (null === $startsAt || null === $endsAt) {
                    $this->logger->warning('Cannot collect start or end time for talk', [
                        'title' => $title,
                        'startsAt' => $startsAt,
                        'endsAt' => $endsAt,
                    ]);

                    return;
                }

                $slots[] = new Slot(
                    $title,
                    new \DateTimeImmutable($startsAt),
                    new \DateTimeImmutable($endsAt),
                    $talk->filter('.schedule-talk-author')->text(),
                    '1' === $talk->attr('colspan') ? self::TRACKS[$index] : null,
                );
            });
        });

        return SlotCollection::array($slots);
    }
}
