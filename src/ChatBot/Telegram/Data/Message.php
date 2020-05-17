<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram\Data;

class Message
{
    public int $messageId;
    public User $from;
    public Chat $chat;
    public \DateTimeImmutable $date;
    public string $text;
}
