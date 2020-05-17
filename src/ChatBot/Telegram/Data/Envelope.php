<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram\Data;

class Envelope
{
    public int $updateId;
    public ?Message $message = null;
    public ?Message $editedMessage = null;
    public ?CallbackQuery $callbackQuery = null;

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
}
