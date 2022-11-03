<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Telegram\Data\Update;

abstract class CommandReplier implements ReplierInterface
{
    public function supports(Update $update): bool
    {
        return str_starts_with($update->getText(), sprintf('/%s', $this->getCommand()));
    }

    public function registerCommand(): bool
    {
        return true;
    }

    public function getDescription(): string
    {
        return '';
    }

    abstract public function getCommand(): string;
}
