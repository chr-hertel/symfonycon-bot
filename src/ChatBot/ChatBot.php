<?php

declare(strict_types=1);

namespace App\ChatBot;

use App\ChatBot\Telegram\Data\Envelope;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(method: 'consume')]
final class ChatBot
{
    public function __construct(
        private readonly ReplyMachine $replier,
        private readonly ReplySender $sender,
        private readonly LoggerInterface $logger = new NullLogger(),
    ) {
    }

    public function consume(Envelope $envelope): void
    {
        try {
            $senderId = $envelope->getSenderId();
        } catch (\RuntimeException $exception) {
            $this->logger->error('Cannot extract message nor sender', ['exception' => $exception]);

            return;
        }

        $reply = $this->replier
            ->findReply($envelope)
            ->forRecipient($senderId);

        $this->sender->handle($reply);
    }
}
