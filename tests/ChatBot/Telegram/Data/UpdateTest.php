<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Telegram\Data;

use App\ChatBot\Telegram\Data\CallbackQuery;
use App\ChatBot\Telegram\Data\Message;
use App\ChatBot\Telegram\Data\Update;
use PHPUnit\Framework\TestCase;

final class UpdateTest extends TestCase
{
    public function testExceptionWithoutMessage(): void
    {
        $update = new Update();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Unable to extract message.');

        $update->getMessage();
    }

    public function testRetrieveCallbackMessage(): void
    {
        $update = new Update();

        $callbackMessage = new Message();
        $callback = new CallbackQuery();
        $callback->message = $callbackMessage;
        $update->callbackQuery = $callback;

        static::assertSame($callbackMessage, $update->getMessage());
    }

    public function testRetrieveEditedMessage(): void
    {
        $update = new Update();

        $editedMessage = new Message();
        $update->editedMessage = $editedMessage;

        static::assertSame($editedMessage, $update->getMessage());
    }

    public function testRetrieveMessage(): void
    {
        $update = new Update();

        $message = new Message();
        $update->message = $message;

        static::assertSame($message, $update->getMessage());
    }

    public function testRetrieveMessageBeforeEditedMessage(): void
    {
        $update = new Update();

        $message = new Message();
        $update->message = $message;

        $editedMessage = new Message();
        $update->editedMessage = $editedMessage;

        static::assertSame($message, $update->getMessage());
    }

    public function testRetrieveMessageBeforeEditedMessageBeforeCallbackMessage(): void
    {
        $update = new Update();

        $message = new Message();
        $update->message = $message;

        $editedMessage = new Message();
        $update->editedMessage = $editedMessage;

        $callbackMessage = new Message();
        $callback = new CallbackQuery();
        $callback->message = $callbackMessage;
        $update->callbackQuery = $callback;

        static::assertSame($message, $update->getMessage());
    }

    public function testRetrieveEditedMessageBeforeCallbackMessage(): void
    {
        $update = new Update();

        $editedMessage = new Message();
        $update->editedMessage = $editedMessage;

        $callbackMessage = new Message();
        $callback = new CallbackQuery();
        $callback->message = $callbackMessage;
        $update->callbackQuery = $callback;

        static::assertSame($editedMessage, $update->getMessage());
    }
}
