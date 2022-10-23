<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Reply;
use App\ChatBot\Telegram\Data\Envelope;
use App\SymfonyCon\Schedule;

final class NextReplier extends CommandReplier
{
    public function __construct(private readonly Schedule $schedule)
    {
    }

    public function getCommand(): string
    {
        return 'next';
    }

    public function getDescription(): string
    {
        return 'Lists all talks happening next slot';
    }

    public function reply(Envelope $envelope): Reply
    {
        return new Reply((string) $this->schedule->next());
    }
}
