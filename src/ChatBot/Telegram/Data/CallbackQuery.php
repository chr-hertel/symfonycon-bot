<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram\Data;

final class CallbackQuery
{
    public string $id;
    public User $from;
    public Message|null $message = null;
    public string|null $inlineMessageId = null;
    public string $chatInstance;
    public string|null $data = null;
}
