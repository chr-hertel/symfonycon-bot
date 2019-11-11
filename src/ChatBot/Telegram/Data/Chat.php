<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram\Data;

class Chat
{
    /** @var int */
    public $id;
    /** @var string */
    public $firstName;
    /** @var string */
    public $lastName;
    /** @var string */
    public $type;
}
