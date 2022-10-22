<?php

declare(strict_types=1);

namespace App\ChatBot\Reply;

final class TextReply extends Reply
{
    public function __construct(public readonly string $text)
    {
    }
}
