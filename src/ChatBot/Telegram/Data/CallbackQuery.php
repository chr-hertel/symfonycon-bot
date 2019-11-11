<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram\Data;

class CallbackQuery
{
    public $id;
    /** @var User */
    public $from;
    /** @var Message */
    public $message;
    public $chatInstance;
    public $data;
}
