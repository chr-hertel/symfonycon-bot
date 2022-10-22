<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram\Data;

final class CallbackQuery
{
    public string $id;
    public User $from;
    public Message $message;
    public string $chatInstance;
    public string $data;
}
