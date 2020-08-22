<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Replier;

use App\ChatBot\Replier\StartReplier;
use App\ChatBot\Telegram\Data\Envelope;
use App\ChatBot\Telegram\Data\Message;
use App\ChatBot\Telegram\Data\User;
use PHPUnit\Framework\TestCase;

class StartReplierTest extends TestCase
{
    private StartReplier $replier;

    public function testSupportingStartMessage(): void
    {
        $message = new Message();
        $message->text = '/start';
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

    public function testStartText(): void
    {
        $user = new User();
        $user->firstName = 'Chris';
        $message = new Message();
        $message->from = $user;
        $envelope = new Envelope();
        $envelope->message = $message;

        $expectedText = 'Welcome to SymfonyConBot, Chris! :)'.PHP_EOL.'Use /help to see all commands.';
        $reply = $this->replier->reply($envelope);

        static::assertSame($expectedText, $reply->getText());
    }

    protected function setUp(): void
    {
        $this->replier = new StartReplier();
    }
}
