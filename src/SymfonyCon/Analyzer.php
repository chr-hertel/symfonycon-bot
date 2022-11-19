<?php

declare(strict_types=1);

namespace App\SymfonyCon;

use Doctrine\DBAL\Connection;

final class Analyzer
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @return list<array{title: string, speaker: string, attendees: int, ratings: int, average: float}>
     */
    public function createAnalysis(): array
    {
        $query = <<<SQL
            SELECT talk.title, talk.speaker, attendance.attendees, rating.ratings, rating.average
                FROM event AS talk
                JOIN (SELECT talk_id, count(*) AS attendees FROM attendance GROUP BY talk_id) AS attendance ON talk.id = attendance.talk_id
                JOIN (SELECT talk_id, count(*) AS ratings, avg(rating) AS average FROM attendee_rating GROUP BY talk_id) AS rating ON talk.id = rating.talk_id
                WHERE talk.dtype = 'talk'
                ORDER BY average DESC, ratings DESC;
        SQL;

        return dump($this->connection->executeQuery($query)->fetchAllAssociative());
    }
}
