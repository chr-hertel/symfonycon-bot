<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Replier;

use App\ChatBot\Replier\StartReplier;
use App\ChatBot\Telegram\Data\Message;
use App\ChatBot\Telegram\Data\Update;
use App\ChatBot\Telegram\Data\User;
use PHPUnit\Framework\TestCase;

final class StartReplierTest extends TestCase
{
    private StartReplier $replier;

    public function testSupportingStartMessage(): void
    {
        $message = new Message();
        $message->text = '/start';
        $update = new Update();
        $update->message = $message;

        static::assertTrue($this->replier->supports($update));
    }

    public function testNotSupportingRandomMessage(): void
    {
        $message = new Message();
        $message->text = '/countdown';
        $update = new Update();
        $update->message = $message;

        static::assertFalse($this->replier->supports($update));
    }

    public function testStartText(): void
    {
        $user = new User();
        $user->firstName = 'Chris';
        $message = new Message();
        $message->from = $user;
        $update = new Update();
        $update->message = $message;

        $expectedText = 'Welcome to SymfonyConBot, Chris! :)'.PHP_EOL.'Use /help to see all commands.';
        $chatMessage = $this->replier->reply($update);

        static::assertSame($expectedText, $chatMessage->getSubject());
    }

    protected function setUp(): void
    {
        $this->replier = new StartReplier();
    }
}
