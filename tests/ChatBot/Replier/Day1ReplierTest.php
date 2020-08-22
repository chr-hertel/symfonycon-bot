<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Replier;

use App\ChatBot\Replier\Day1Replier;
use App\ChatBot\Reply;
use App\ChatBot\Telegram\Data\Envelope;
use App\ChatBot\Telegram\Data\Message;
use App\SymfonyCon\Schedule;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class Day1ReplierTest extends TestCase
{
    /** @var MockObject&Schedule */
    private MockObject $schedule;
    private Day1Replier $replier;

    public function testSupportingDay1Message(): void
    {
        $message = new Message();
        $message->text = '/day1';
        $envelope = new Envelope();
        $envelope->message = $message;

        static::assertTrue($this->replier->supports($envelope));
    }

    public function testNotSupportingRandomMessage(): void
    {
        $message = new Message();
        $message->text = '/day2';
        $envelope = new Envelope();
        $envelope->message = $message;

        static::assertFalse($this->replier->supports($envelope));
    }

    public function testDay1Reply(): void
    {
        $this->schedule
            ->expects(static::once())
            ->method('day1');

        $reply = $this->replier->reply(new Envelope());

        static::assertInstanceOf(Reply::class, $reply);
    }

    protected function setUp(): void
    {
        $this->schedule = $this->getMockBuilder(Schedule::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->replier = new Day1Replier($this->schedule);
    }
}
