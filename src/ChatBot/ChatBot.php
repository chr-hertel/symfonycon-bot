<?php

declare(strict_types=1);

namespace App\ChatBot;

use App\ChatBot\Telegram\Data\Envelope;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

class ChatBot
{
    public function __construct(
        private readonly ReplyMachine $replier,
        private readonly ChatterInterface $chatter,
    ) {
    }

    public function consume(Envelope $envelope): void
    {
        $reply = $this->replier->findReply($envelope);
        $chatId = (string) $envelope->getMessage()->chat->id;

        $options = (new TelegramOptions())
            ->chatId($chatId)
            ->parseMode(TelegramOptions::PARSE_MODE_MARKDOWN);

        $this->chatter->send(
            new ChatMessage($reply->getText(), $options)
        );
    }
}
