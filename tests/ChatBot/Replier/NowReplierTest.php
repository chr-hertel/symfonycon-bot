<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Replier;

use App\ChatBot\Replier\NowReplier;
use App\ChatBot\Telegram\Data\Message;
use App\ChatBot\Telegram\Data\Update;
use App\SymfonyCon\Schedule;
use App\Tests\Renderer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Notifier\Message\ChatMessage;

final class NowReplierTest extends TestCase
{
    use Renderer;

    /** @var MockObject&Schedule */
    private MockObject $schedule;
    private NowReplier $replier;

    public function testSupportingNowMessage(): void
    {
        $message = new Message();
        $message->text = '/now';
        $update = new Update();
        $update->message = $message;

        self::assertTrue($this->replier->supports($update));
    }

    public function testNotSupportingRandomMessage(): void
    {
        $message = new Message();
        $message->text = '/next';
        $update = new Update();
        $update->message = $message;

        self::assertFalse($this->replier->supports($update));
    }

    public function testNowReply(): void
    {
        $this->schedule
            ->expects(self::once())
            ->method('now');

        $chatMessage = $this->replier->reply(new Update());

        self::assertInstanceOf(ChatMessage::class, $chatMessage);
    }

    protected function setUp(): void
    {
        $this->setUpSlotRenderer();
        $this->schedule = $this->getMockBuilder(Schedule::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->replier = new NowReplier($this->schedule, $this->slotRenderer);
    }
}
