<?php

declare(strict_types=1);

namespace App\Tests\ChatBot;

use App\ChatBot\ChatBot;
use App\ChatBot\Replier\HelpReplier;
use App\ChatBot\Replier\StartReplier;
use App\ChatBot\ReplyMachine;
use App\ChatBot\Telegram\Data\Chat;
use App\ChatBot\Telegram\Data\Message;
use App\ChatBot\Telegram\Data\Update;
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
            ->expects(self::once())
            ->method('send')
            ->with(self::isInstanceOf(ChatMessage::class));

        $update = new Update();
        $update->message = new Message();
        $update->message->text = '/help';
        $update->message->chat = new Chat();
        $update->message->chat->id = 1234;

        $chatBot = new ChatBot($replyMachine, $chatter);
        $chatBot->consume($update);
    }
}
