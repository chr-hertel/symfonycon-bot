<?php

declare(strict_types=1);

namespace App\ChatBot\Reply;

abstract class Reply
{
    private string $recipient;

    public function forRecipient(string $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }
}
