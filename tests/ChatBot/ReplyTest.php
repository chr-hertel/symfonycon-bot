<?php

declare(strict_types=1);

namespace App\Tests\ChatBot;

use App\ChatBot\Reply;
use PHPUnit\Framework\TestCase;

class ReplyTest extends TestCase
{
    public function testReplyText(): void
    {
        $reply = new Reply('Hello World');

        static::assertSame('Hello World', $reply->getText());
    }
}
