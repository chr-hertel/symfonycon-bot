<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram\Data;

class Envelope
{
    /** @var int */
    public $updateId;
    /** @var Message|null */
    public $message;
    /** @var Message|null */
    public $editedMessage;
    /** @var CallbackQuery|null */
    public $callbackQuery;

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
