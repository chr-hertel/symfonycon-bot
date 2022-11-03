<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Telegram\Data\Update;
use App\SymfonyCon\Search;
use Symfony\Component\Notifier\Message\ChatMessage;
use Twig\Environment;

final class SearchReplier extends CommandReplier
{
    public function __construct(private readonly Search $search, private readonly Environment $twig)
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

    public function reply(Update $update): ChatMessage
    {
        // remove "/search" from message text
        $query = trim(substr($update->getText(), 7));

        if (empty($query)) {
            return new ChatMessage('Please add a search term, like "/search Symfony 6.2".');
        }

        return new ChatMessage(
            $this->twig->render('search.html.twig', [
                'query' => $query,
                'talks' => $this->search->search($query),
            ])
        );
    }
}
