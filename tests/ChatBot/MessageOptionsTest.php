<?php

declare(strict_types=1);

namespace App\Tests\ChatBot;

use App\ChatBot\MessageOptions;
use App\ChatBot\Telegram\Data\Chat;
use App\ChatBot\Telegram\Data\Envelope;
use App\ChatBot\Telegram\Data\Message;
use PHPUnit\Framework\TestCase;

class MessageOptionsTest extends TestCase
{
    public function testInstantiationFromEnvelope(): void
    {
        $message = new Message();
        $message->chat = new Chat();
        $message->chat->id = 1234;
        $envelope = new Envelope();
        $envelope->message = $message;

        $msgOptions = MessageOptions::fromEnvelope($envelope, ['foo' => 'bar']);

        static::assertSame(['foo' => 'bar'], $msgOptions->toArray());
        static::assertSame('1234', $msgOptions->getRecipientId());
    }
}
