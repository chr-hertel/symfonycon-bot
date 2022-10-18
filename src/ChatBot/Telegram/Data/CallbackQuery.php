<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram\Data;

final class CallbackQuery
{
    public int $id;
    public User $from;
    public Message $message;
    public int $chatInstance;
    public string $data;
}
