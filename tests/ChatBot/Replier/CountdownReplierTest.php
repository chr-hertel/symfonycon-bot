<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Replier;

use App\ChatBot\Replier\CountdownReplier;
use App\ChatBot\Telegram\Data\Message;
use App\ChatBot\Telegram\Data\Update;
use App\SymfonyCon\Timer;
use PHPUnit\Framework\TestCase;

final class CountdownReplierTest extends TestCase
{
    private CountdownReplier $replier;

    public function testSupportingCountdownMessage(): void
    {
        $message = new Message();
        $message->text = '/countdown';
        $update = new Update();
        $update->message = $message;

        static::assertTrue($this->replier->supports($update));
    }

    public function testNotSupportingRandomMessage(): void
    {
        $message = new Message();
        $message->text = '/help';
        $update = new Update();
        $update->message = $message;

        static::assertFalse($this->replier->supports($update));
    }

    public function testCountdownText(): void
    {
        $expectedText = 'Only <b>2 days, 12 hours and 45 minutes</b> until SymfonyCon starts.';

        $chatMessage = $this->replier->reply(new Update());
        static::assertSame($expectedText, $chatMessage->getSubject());
    }

    protected function setUp(): void
    {
        $timer = new Timer(
            new \DateTimeImmutable('11/21/19 08:00'),
            new \DateTimeImmutable('11/22/19 17:00'),
            new \DateTimeImmutable('11/18/19 19:15')
        );
        $this->replier = new CountdownReplier($timer);
    }
}
