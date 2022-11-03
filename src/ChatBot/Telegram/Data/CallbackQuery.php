<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram\Data;

final class CallbackQuery
{
    public string $id;
    public User $from;
    public ?Message $message = null;
    public ?string $inlineMessageId = null;
    public string $chatInstance;
    public ?string $data = null;
}
