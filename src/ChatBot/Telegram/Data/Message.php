<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram\Data;

class Message
{
    public $messageId;
    /** @var User */
    public $from;
    /** @var Chat */
    public $chat;
    public $date;
    public $text;
}
