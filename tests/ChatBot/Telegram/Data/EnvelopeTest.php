<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Telegram\Data;

use App\ChatBot\Telegram\Data\CallbackQuery;
use App\ChatBot\Telegram\Data\Envelope;
use App\ChatBot\Telegram\Data\Message;
use PHPUnit\Framework\TestCase;

final class EnvelopeTest extends TestCase
{
    public function testExceptionWithoutMessage(): void
    {
        $envelope = new Envelope();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Unable to extract message.');

        $envelope->getMessage();
    }

    public function testRetrieveCallbackMessage(): void
    {
        $envelope = new Envelope();

        $callbackMessage = new Message();
        $callback = new CallbackQuery();
        $callback->message = $callbackMessage;
        $envelope->callbackQuery = $callback;

        static::assertSame($callbackMessage, $envelope->getMessage());
    }

    public function testRetrieveEditedMessage(): void
    {
        $envelope = new Envelope();

        $editedMessage = new Message();
        $envelope->editedMessage = $editedMessage;

        static::assertSame($editedMessage, $envelope->getMessage());
    }

    public function testRetrieveMessage(): void
    {
        $envelope = new Envelope();

        $message = new Message();
        $envelope->message = $message;

        static::assertSame($message, $envelope->getMessage());
    }

    public function testRetrieveMessageBeforeEditedMessage(): void
    {
        $envelope = new Envelope();

        $message = new Message();
        $envelope->message = $message;

        $editedMessage = new Message();
        $envelope->editedMessage = $editedMessage;

        static::assertSame($message, $envelope->getMessage());
    }

    public function testRetrieveMessageBeforeEditedMessageBeforeCallbackMessage(): void
    {
        $envelope = new Envelope();

        $message = new Message();
        $envelope->message = $message;

        $editedMessage = new Message();
        $envelope->editedMessage = $editedMessage;

        $callbackMessage = new Message();
        $callback = new CallbackQuery();
        $callback->message = $callbackMessage;
        $envelope->callbackQuery = $callback;

        static::assertSame($message, $envelope->getMessage());
    }

    public function testRetrieveEditedMessageBeforeCallbackMessage(): void
    {
        $envelope = new Envelope();

        $editedMessage = new Message();
        $envelope->editedMessage = $editedMessage;

        $callbackMessage = new Message();
        $callback = new CallbackQuery();
        $callback->message = $callbackMessage;
        $envelope->callbackQuery = $callback;

        static::assertSame($editedMessage, $envelope->getMessage());
    }
}
