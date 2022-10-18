<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Telegram\Data\Envelope;

abstract class CommandReplier implements ReplierInterface
{
    public function supports(Envelope $envelope): bool
    {
        return str_starts_with($envelope->getMessage()->text, sprintf('/%s', $this->getCommand()));
    }

    public function registerCommand(): bool
    {
        return true;
    }

    abstract public function getCommand(): string;

    abstract public function getDescription(): string;
}
