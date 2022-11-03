<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram\Data;

final class Update
{
    public int $updateId;
    public ?Message $message = null;
    public ?Message $editedMessage = null;
    public ?CallbackQuery $callbackQuery = null;

    public function isMessage(): bool
    {
        return null !== $this->message || null !== $this->editedMessage;
    }

    public function isCallback(): bool
    {
        return $this->callbackQuery instanceof CallbackQuery;
    }

    public function getText(): string
    {
        if ($this->isCallback()) {
            return $this->callbackQuery->data ?? '';
        }

        return $this->getMessage()->text;
    }

    public function getMessage(): Message
    {
        if ($this->message instanceof Message) {
            return $this->message;
        }

        if ($this->editedMessage instanceof Message) {
            return $this->editedMessage;
        }

        if ($this->callbackQuery instanceof CallbackQuery && $this->callbackQuery->message instanceof Message) {
            return $this->callbackQuery->message;
        }

        throw new \RuntimeException('Unable to extract message.');
    }

    public function getChatId(): string
    {
        return (string) $this->getMessage()->chat->id;
    }
}
