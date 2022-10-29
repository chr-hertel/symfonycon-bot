<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Replier;

use App\ChatBot\Replier\Renderer\DayRenderer;
use App\ChatBot\Replier\TodayReplier;
use App\ChatBot\Telegram\Data\Message;
use App\ChatBot\Telegram\Data\Update;
use App\SymfonyCon\Schedule;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Notifier\Message\ChatMessage;

final class TodayReplierTest extends TestCase
{
    /** @var MockObject&Schedule */
    private MockObject $schedule;
    private TodayReplier $replier;

    public function testSupportingTodayMessage(): void
    {
        $message = new Message();
        $message->text = '/today';
        $update = new Update();
        $update->message = $message;

        self::assertTrue($this->replier->supports($update));
    }

    public function testNotSupportingRandomMessage(): void
    {
        $message = new Message();
        $message->text = '/start';
        $update = new Update();
        $update->message = $message;

        self::assertFalse($this->replier->supports($update));
    }

    public function testTodayReply(): void
    {
        $this->schedule
            ->expects(self::once())
            ->method('today');

        $chatMessage = $this->replier->reply(new Update());

        self::assertInstanceOf(ChatMessage::class, $chatMessage);
    }

    protected function setUp(): void
    {
        $this->schedule = $this->getMockBuilder(Schedule::class)
            ->disableOriginalConstructor()
            ->getMock();
        $renderer = $this->createMock(DayRenderer::class);
        $this->replier = new TodayReplier($this->schedule, $renderer);
    }
}
