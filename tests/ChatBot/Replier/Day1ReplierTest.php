<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Replier;

use App\ChatBot\Replier\Day1Replier;
use App\ChatBot\Replier\Renderer\DayRenderer;
use App\ChatBot\Telegram\Data\Message;
use App\ChatBot\Telegram\Data\Update;
use App\SymfonyCon\Schedule;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Notifier\Message\ChatMessage;

final class Day1ReplierTest extends TestCase
{
    /** @var MockObject&Schedule */
    private MockObject $schedule;
    private Day1Replier $replier;

    public function testSupportingDay1Message(): void
    {
        $message = new Message();
        $message->text = '/day1';
        $update = new Update();
        $update->message = $message;

        self::assertTrue($this->replier->supports($update));
    }

    public function testNotSupportingRandomMessage(): void
    {
        $message = new Message();
        $message->text = '/day2';
        $update = new Update();
        $update->message = $message;

        self::assertFalse($this->replier->supports($update));
    }

    public function testDay1Reply(): void
    {
        $this->schedule
            ->expects(self::once())
            ->method('day1');

        $chatMessage = $this->replier->reply(new Update());

        self::assertInstanceOf(ChatMessage::class, $chatMessage);
    }

    protected function setUp(): void
    {
        $this->schedule = $this->getMockBuilder(Schedule::class)
            ->disableOriginalConstructor()
            ->getMock();
        $renderer = $this->createMock(DayRenderer::class);
        $this->replier = new Day1Replier($this->schedule, $renderer);
    }
}
