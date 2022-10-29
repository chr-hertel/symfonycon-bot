<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Replier;

use App\ChatBot\Replier\NextReplier;
use App\ChatBot\Telegram\Data\Message;
use App\ChatBot\Telegram\Data\Update;
use App\SymfonyCon\Schedule;
use App\Tests\Renderer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Notifier\Message\ChatMessage;

final class NextReplierTest extends TestCase
{
    use Renderer;

    /** @var MockObject&Schedule */
    private MockObject $schedule;
    private NextReplier $replier;

    public function testSupportingNextMessage(): void
    {
        $message = new Message();
        $message->text = '/next';
        $update = new Update();
        $update->message = $message;

        self::assertTrue($this->replier->supports($update));
    }

    public function testNotSupportingRandomMessage(): void
    {
        $message = new Message();
        $message->text = '/now';
        $update = new Update();
        $update->message = $message;

        self::assertFalse($this->replier->supports($update));
    }

    public function testNextReply(): void
    {
        $this->schedule
            ->expects(self::once())
            ->method('next');

        $chatMessage = $this->replier->reply(new Update());

        self::assertInstanceOf(ChatMessage::class, $chatMessage);
    }

    protected function setUp(): void
    {
        $this->setUpSlotRenderer();
        $this->schedule = $this->getMockBuilder(Schedule::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->replier = new NextReplier($this->schedule, $this->slotRenderer);
    }
}
