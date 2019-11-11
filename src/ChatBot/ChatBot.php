<?php

declare(strict_types=1);

namespace App\ChatBot;

use App\ChatBot\Telegram\Data\Envelope;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

class ChatBot
{
    private $replier;
    private $chatter;

    public function __construct(ReplyMachine $replier, ChatterInterface $chatter)
    {
        $this->replier = $replier;
        $this->chatter = $chatter;
    }

    public function consume(Envelope $envelope): void
    {
        $reply = $this->replier->findReply($envelope);

        $this->chatter->send(
            new ChatMessage($reply->getText(), MessageOptions::fromEnvelope($envelope, [
                'reply_markup' => $reply->getMarkup(),
            ]))
        );
    }
}
