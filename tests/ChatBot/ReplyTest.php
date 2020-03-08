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

    public function testReplyMarkup(): void
    {
        $reply = new Reply('Hello World', ['context' => 'Markdown']);

        static::assertSame(['context' => 'Markdown'], $reply->getMarkup());
    }

    public function testEmptyMarkup(): void
    {
        $reply = new Reply('Hello World');

        static::assertSame([], $reply->getMarkup());
    }
}
