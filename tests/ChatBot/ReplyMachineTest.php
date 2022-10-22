<?php

declare(strict_types=1);

namespace App\Tests\ChatBot;

use App\ChatBot\Replier\CountdownReplier;
use App\ChatBot\Replier\HelpReplier;
use App\ChatBot\Replier\StartReplier;
use App\ChatBot\Reply\MarkdownReply;
use App\ChatBot\Reply\TextReply;
use App\ChatBot\ReplyMachine;
use App\ChatBot\Telegram\Data\Envelope;
use App\ChatBot\Telegram\Data\Message;
use App\ChatBot\Telegram\Data\User;
use App\SymfonyCon\Timer;
use PHPUnit\Framework\TestCase;

final class ReplyMachineTest extends TestCase
{
    private ReplyMachine $replyMachine;

    protected function setUp(): void
    {
        $timer = new Timer(
            new \DateTimeImmutable('11/21/19 08:00'),
            new \DateTimeImmutable('11/22/19 17:00'),
            new \DateTimeImmutable('11/18/19 19:15'),
        );
        $replier = [
            new StartReplier(),
            new CountdownReplier($timer),
            new HelpReplier(),
        ];

        $this->replyMachine = new ReplyMachine($replier);
    }

    /**
     * @dataProvider provideValidMessageForText
     */
    public function testValidMessageGetsTextReply(string $text, string $expectedReply): void
    {
        $user = new User();
        $user->firstName = 'Chris';
        $message = new Message();
        $message->text = $text;
        $message->from = $user;
        $envelope = new Envelope();
        $envelope->message = $message;

        $reply = $this->replyMachine->findReply($envelope);

        static::assertInstanceOf(TextReply::class, $reply);
        static::assertStringStartsWith($expectedReply, $reply->text);
    }

    /**
     * @return array<array{0: string, 1: string}>
     */
    public function provideValidMessageForText(): array
    {
        return [
            ['/start', 'Welcome to SymfonyConBot, Chris! :)'.PHP_EOL.'Use /help to see all commands.'],
        ];
    }

    /**
     * @dataProvider provideValidMessageForMarkdown
     */
    public function testValidMessageGetsMarkdownReply(string $text, string $expectedReply): void
    {
        $user = new User();
        $user->firstName = 'Chris';
        $message = new Message();
        $message->text = $text;
        $message->from = $user;
        $envelope = new Envelope();
        $envelope->message = $message;

        $reply = $this->replyMachine->findReply($envelope);

        static::assertInstanceOf(MarkdownReply::class, $reply);
        static::assertStringStartsWith($expectedReply, $reply->markdown);
    }

    /**
     * @return array<array{0: string, 1: string}>
     */
    public function provideValidMessageForMarkdown(): array
    {
        return [
            ['/help', '*SymfonyConBot Help*'.PHP_EOL.'This bot will help you to keep on track with all talks at SymfonyCon Disneyland Paris 2022.'],
            ['/countdown', 'Only *2 days, 12 hours and 45 minutes* until SymfonyCon starts.'],
        ];
    }

    public function testInvalidMessageGetsReply(): void
    {
        $message = new Message();
        $message->text = '/invalid';
        $envelope = new Envelope();
        $envelope->message = $message;

        $reply = $this->replyMachine->findReply($envelope);
        static::assertInstanceOf(TextReply::class, $reply);
        static::assertSame('Sorry, I didn\'t get that! Please try /help instead!', $reply->text);
    }

    private function createEnvelope(string $text): Envelope
    {
        $user = new User();
        $user->firstName = 'Chris';
        $message = new Message();
        $message->text = $text;
        $message->from = $user;
        $envelope = new Envelope();
        $envelope->message = $message;

        return $envelope;
    }
}
