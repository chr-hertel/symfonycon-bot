<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram\Data;

final class Chat
{
    public int $id;
    public string $firstName;
    public string $lastName;
    public string $type;
}
