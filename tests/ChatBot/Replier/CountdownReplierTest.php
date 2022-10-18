<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Replier;

use App\ChatBot\Replier\CountdownReplier;
use App\ChatBot\Telegram\Data\Envelope;
use App\ChatBot\Telegram\Data\Message;
use App\SymfonyCon\Timer;
use PHPUnit\Framework\TestCase;

final class CountdownReplierTest extends TestCase
{
    private CountdownReplier $replier;

    public function testSupportingCountdownMessage(): void
    {
        $message = new Message();
        $message->text = '/countdown';
        $envelope = new Envelope();
        $envelope->message = $message;

        static::assertTrue($this->replier->supports($envelope));
    }

    public function testNotSupportingRandomMessage(): void
    {
        $message = new Message();
        $message->text = '/help';
        $envelope = new Envelope();
        $envelope->message = $message;

        static::assertFalse($this->replier->supports($envelope));
    }

    public function testCountdownText(): void
    {
        $expectedText = '2 days, 12 hours and 45 minutes';

        $reply = $this->replier->reply(new Envelope());
        static::assertSame($expectedText, $reply->getText());
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
