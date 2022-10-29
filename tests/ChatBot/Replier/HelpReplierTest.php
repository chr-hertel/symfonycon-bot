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

        self::assertTrue($this->replier->supports($update));
    }

    public function testNotSupportingRandomMessage(): void
    {
        $message = new Message();
        $message->text = '/countdown';
        $update = new Update();
        $update->message = $message;

        self::assertFalse($this->replier->supports($update));
    }

    public function testHelpText(): void
    {
        $chatMessage = $this->replier->reply(new Update());

        self::assertStringContainsString('/countdown', $chatMessage->getSubject());
        self::assertStringContainsString('/day1', $chatMessage->getSubject());
        self::assertStringContainsString('/day2', $chatMessage->getSubject());
        self::assertStringContainsString('/today', $chatMessage->getSubject());
        self::assertStringContainsString('/now', $chatMessage->getSubject());
        self::assertStringContainsString('/next', $chatMessage->getSubject());
    }

    protected function setUp(): void
    {
        $this->replier = new HelpReplier();
    }
}
