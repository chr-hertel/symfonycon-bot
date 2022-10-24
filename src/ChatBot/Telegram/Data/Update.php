<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram\Data;

final class Update
{
    public int $updateId;
    public Message|null $message = null;
    public Message|null $editedMessage = null;
    public CallbackQuery|null $callbackQuery = null;

    public function isMessage(): bool
    {
        return null !== $this->message || null !== $this->editedMessage;
    }

    public function isCallback(): bool
    {
        return null !== $this->callbackQuery;
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
