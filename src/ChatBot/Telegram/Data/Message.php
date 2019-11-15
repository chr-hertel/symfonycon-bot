<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram\Data;

class Message
{
    /** @var int */
    public $messageId;
    /** @var User */
    public $from;
    /** @var Chat */
    public $chat;
    /** @var \DateTimeImmutable */
    public $date;
    /** @var string */
    public $text;
}
