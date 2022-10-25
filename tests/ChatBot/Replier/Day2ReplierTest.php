<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Replier;

use App\ChatBot\Replier\Day2Replier;
use App\ChatBot\Replier\Renderer\DayRenderer;
use App\ChatBot\Telegram\Data\Message;
use App\ChatBot\Telegram\Data\Update;
use App\SymfonyCon\Schedule;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Notifier\Message\ChatMessage;

final class Day2ReplierTest extends TestCase
{
    /** @var MockObject&Schedule */
    private MockObject $schedule;
    private Day2Replier $replier;

    public function testSupportingDay2Message(): void
    {
        $message = new Message();
        $message->text = '/day2';
        $update = new Update();
        $update->message = $message;

        static::assertTrue($this->replier->supports($update));
    }

    public function testNotSupportingRandomMessage(): void
    {
        $message = new Message();
        $message->text = '/day1';
        $update = new Update();
        $update->message = $message;

        static::assertFalse($this->replier->supports($update));
    }

    public function testDay2Reply(): void
    {
        $this->schedule
            ->expects(static::once())
            ->method('day2');

        $chatMessage = $this->replier->reply(new Update());

        static::assertInstanceOf(ChatMessage::class, $chatMessage);
    }

    protected function setUp(): void
    {
        $this->schedule = $this->getMockBuilder(Schedule::class)
            ->disableOriginalConstructor()
            ->getMock();
        $renderer = $this->createMock(DayRenderer::class);
        $this->replier = new Day2Replier($this->schedule, $renderer);
    }
}
