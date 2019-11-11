<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram\Data;

class Envelope
{
    public $updateId;
    /** @var Message */
    public $message;
    /** @var Message */
    public $editedMessage;
    /** @var CallbackQuery */
    public $callbackQuery;

    public function getMessage(): Message
    {
        if ($this->message instanceof Message) {
            return $this->message;
        }

        if ($this->editedMessage instanceof Message) {
            return $this->editedMessage;
        }

        if ($this->callbackQuery->message instanceof Message) {
            return $this->callbackQuery->message;
        }

        throw new \RuntimeException('Unable to extract message.');
    }
}
