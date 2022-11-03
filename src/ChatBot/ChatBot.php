<?php

declare(strict_types=1);

namespace App\ChatBot;

use App\ChatBot\Telegram\Data\Update;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;

final class ChatBot
{
    public function __construct(
        private readonly ReplyMachine $replier,
        private readonly ChatterInterface $chatter,
        private readonly LoggerInterface $logger = new NullLogger(),
    ) {
    }

    public function consume(Update $update): void
    {
        $chatMessage = $this->replier->findReply($update);
        try {
            $chatId = $update->getChatId();
        } catch (\RuntimeException $exception) {
            $this->logger->error('Cannot extract message nor sender', ['exception' => $exception]);

            return;
        }

        /** @var TelegramOptions $options */
        $options = $chatMessage->getOptions() ?? new TelegramOptions();
        $options
            ->chatId((string) $chatId)
            ->parseMode(TelegramOptions::PARSE_MODE_HTML);

        $this->chatter->send(
            $chatMessage->options($options)
        );
    }
}
