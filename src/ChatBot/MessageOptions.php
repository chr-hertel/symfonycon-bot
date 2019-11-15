<?php

declare(strict_types=1);

namespace App\ChatBot;

use App\ChatBot\Telegram\Data\Envelope;
use Symfony\Component\Notifier\Message\MessageOptionsInterface;

class MessageOptions implements MessageOptionsInterface
{
    private $chatId;
    private $options = [];

    public static function fromEnvelope(Envelope $envelope, array $options = []): self
    {
        $instance = new self();
        $instance->chatId = (string) $envelope->getMessage()->chat->id;
        $instance->options = $options;

        return $instance;
    }

    public function toArray(): array
    {
        return $this->options;
    }

    public function getRecipientId(): string
    {
        return $this->chatId;
    }
}
