<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Reply\SlotReply;
use App\ChatBot\Reply\TextReply;
use App\ChatBot\Telegram\Data\Envelope;
use App\SymfonyCon\Search;

final class SearchReplier extends CommandReplier
{
    public function __construct(private readonly Search $search)
    {
    }

    public function getCommand(): string
    {
        return 'search';
    }

    public function getDescription(): string
    {
        return 'Search for talks within the schedule';
    }

    public function reply(Envelope $envelope): TextReply|SlotReply
    {
        // remove "/search" from message text
        $query = trim(substr($envelope->getMessage()->text, 7));

        if (empty($query)) {
            return new TextReply('Please add a search term, like "/search Symfony 6.2".');
        }

        return new SlotReply($this->search->search($query));
    }
}
