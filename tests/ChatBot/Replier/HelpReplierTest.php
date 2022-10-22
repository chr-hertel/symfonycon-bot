<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Replier;

use App\ChatBot\Replier\HelpReplier;
use App\ChatBot\Reply\MarkdownReply;
use App\ChatBot\Telegram\Data\Envelope;
use App\ChatBot\Telegram\Data\Message;
use PHPUnit\Framework\TestCase;

final class HelpReplierTest extends TestCase
{
    private HelpReplier $replier;

    public function testSupportingHelpMessage(): void
    {
        $message = new Message();
        $message->text = '/help';
        $envelope = new Envelope();
        $envelope->message = $message;

        static::assertTrue($this->replier->supports($envelope));
    }

    public function testNotSupportingRandomMessage(): void
    {
        $message = new Message();
        $message->text = '/countdown';
        $envelope = new Envelope();
        $envelope->message = $message;

        static::assertFalse($this->replier->supports($envelope));
    }

    public function testHelpText(): void
    {
        $reply = $this->replier->reply(new Envelope());

        static::assertInstanceOf(MarkdownReply::class, $reply);
        static::assertStringContainsString('/countdown', $reply->markdown);
        static::assertStringContainsString('/day1', $reply->markdown);
        static::assertStringContainsString('/day2', $reply->markdown);
        static::assertStringContainsString('/today', $reply->markdown);
        static::assertStringContainsString('/now', $reply->markdown);
        static::assertStringContainsString('/next', $reply->markdown);
    }

    protected function setUp(): void
    {
        $this->replier = new HelpReplier();
    }
}
