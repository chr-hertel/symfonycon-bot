<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Replier;

use App\ChatBot\Replier\HelpReplier;
use App\ChatBot\Telegram\Data\Envelope;
use App\ChatBot\Telegram\Data\Message;
use PHPUnit\Framework\TestCase;

class HelpReplierTest extends TestCase
{
    private $replier;

    public function testSupportingCountdownMessage(): void
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

    public function testCountdownText(): void
    {
        $reply = $this->replier->reply(new Envelope());

        static::assertStringContainsString('/countdown', $reply->getText());
        static::assertStringContainsString('/day1', $reply->getText());
        static::assertStringContainsString('/day2', $reply->getText());
        static::assertStringContainsString('/today', $reply->getText());
        static::assertStringContainsString('/now', $reply->getText());
        static::assertStringContainsString('/next', $reply->getText());
    }

    protected function setUp(): void
    {
        $this->replier = new HelpReplier();
    }
}
