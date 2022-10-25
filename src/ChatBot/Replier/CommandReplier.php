<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Telegram\Data\Update;

abstract class CommandReplier implements ReplierInterface
{
    public function supports(Update $update): bool
    {
        $command = $update->callbackQuery->data ?? $update->getMessage()->text;

        return str_starts_with($command, sprintf('/%s', $this->getCommand()));
    }

    public function registerCommand(): bool
    {
        return true;
    }

    abstract public function getCommand(): string;

    abstract public function getDescription(): string;
}
