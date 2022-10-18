<?php

declare(strict_types=1);

namespace App\Tests\ChatBot;

use App\ChatBot\ChatBot;
use App\ChatBot\Replier\HelpReplier;
use App\ChatBot\Replier\StartReplier;
use App\ChatBot\ReplyMachine;
use App\ChatBot\Telegram\Data\Chat;
use App\ChatBot\Telegram\Data\Envelope;
use App\ChatBot\Telegram\Data\Message;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

final class ChatBotTest extends TestCase
{
    public function testChattingReplies(): void
    {
        $replyMachine = new ReplyMachine([
            new HelpReplier(),
            new StartReplier(),
        ]);
        /** @var MockObject&ChatterInterface $chatter */
        $chatter = $this->getMockBuilder(ChatterInterface::class)->getMock();

        $chatter
            ->expects(static::once())
            ->method('send')
            ->with(static::isInstanceOf(ChatMessage::class));

        $envelope = new Envelope();
        $envelope->message = new Message();
        $envelope->message->text = '/help';
        $envelope->message->chat = new Chat();
        $envelope->message->chat->id = 1234;

        $chatBot = new ChatBot($replyMachine, $chatter);
        $chatBot->consume($envelope);
    }
}
