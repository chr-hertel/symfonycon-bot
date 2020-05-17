<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram\Data;

class User
{
    public int $id;
    public bool $isBot;
    public string $firstName;
    public string $lastName;
    public string $languageCode;
}
