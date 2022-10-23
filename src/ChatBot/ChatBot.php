<?php

declare(strict_types=1);

namespace App\ChatBot;

use App\ChatBot\Telegram\Data\Envelope;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

#[AsMessageHandler(method: 'consume')]
final class ChatBot
{
    public function __construct(
        private readonly ReplyMachine $replier,
        private readonly ChatterInterface $chatter,
        private readonly LoggerInterface $logger = new NullLogger(),
    ) {
    }

    public function consume(Envelope $envelope): void
    {
        $reply = $this->replier->findReply($envelope);
        try {
            $chatId = (string) $envelope->getMessage()->chat->id;
        } catch (\RuntimeException $exception) {
            $this->logger->error('Cannot extract message nor sender', ['exception' => $exception]);

            return;
        }

        $options = (new TelegramOptions())
            ->chatId($chatId)
            ->parseMode(TelegramOptions::PARSE_MODE_MARKDOWN);

        $this->chatter->send(
            new ChatMessage($reply->getText(), $options)
        );
    }
}
