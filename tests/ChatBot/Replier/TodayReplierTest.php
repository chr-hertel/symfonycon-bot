<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Replier;

use App\ChatBot\Replier\TodayReplier;
use App\ChatBot\Reply;
use App\ChatBot\Telegram\Data\Envelope;
use App\ChatBot\Telegram\Data\Message;
use App\SymfonyCon\Schedule;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class TodayReplierTest extends TestCase
{
    /** @var MockObject&Schedule */
    private MockObject $schedule;
    private TodayReplier $replier;

    public function testSupportingTodayMessage(): void
    {
        $message = new Message();
        $message->text = '/today';
        $envelope = new Envelope();
        $envelope->message = $message;

        static::assertTrue($this->replier->supports($envelope));
    }

    public function testNotSupportingRandomMessage(): void
    {
        $message = new Message();
        $message->text = '/start';
        $envelope = new Envelope();
        $envelope->message = $message;

        static::assertFalse($this->replier->supports($envelope));
    }

    public function testTodayReply(): void
    {
        $this->schedule
            ->expects(static::once())
            ->method('today');

        $reply = $this->replier->reply(new Envelope());

        static::assertInstanceOf(Reply::class, $reply);
    }

    protected function setUp(): void
    {
        $this->schedule = $this->getMockBuilder(Schedule::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->replier = new TodayReplier($this->schedule);
    }
}
