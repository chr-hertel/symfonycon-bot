<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram\Data;

class User
{
    /** @var int */
    public $id;
    /** @var bool */
    public $isBot;
    /** @var string */
    public $firstName;
    /** @var string */
    public $lastName;
    /** @var string */
    public $languageCode;
}
