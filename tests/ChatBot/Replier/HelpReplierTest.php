<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Replier;

use App\ChatBot\Replier\HelpReplier;
use App\ChatBot\Telegram\Data\Message;
use App\ChatBot\Telegram\Data\Update;
use PHPUnit\Framework\TestCase;

final class HelpReplierTest extends TestCase
{
    private HelpReplier $replier;

    public function testSupportingHelpMessage(): void
    {
        $message = new Message();
        $message->text = '/help';
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

    public function testHelpText(): void
    {
        $chatMessage = $this->replier->reply(new Update());

        static::assertStringContainsString('/countdown', $chatMessage->getSubject());
        static::assertStringContainsString('/day1', $chatMessage->getSubject());
        static::assertStringContainsString('/day2', $chatMessage->getSubject());
        static::assertStringContainsString('/today', $chatMessage->getSubject());
        static::assertStringContainsString('/now', $chatMessage->getSubject());
        static::assertStringContainsString('/next', $chatMessage->getSubject());
    }

    protected function setUp(): void
    {
        $this->replier = new HelpReplier();
    }
}
