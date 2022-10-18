<?php

declare(strict_types=1);

namespace App\Tests\ChatBot;

use App\ChatBot\Replier\CountdownReplier;
use App\ChatBot\Replier\HelpReplier;
use App\ChatBot\Replier\StartReplier;
use App\ChatBot\ReplyMachine;
use App\ChatBot\Telegram\Data\Envelope;
use App\ChatBot\Telegram\Data\Message;
use App\ChatBot\Telegram\Data\User;
use App\SymfonyCon\Timer;
use PHPUnit\Framework\TestCase;

final class ReplyMachineTest extends TestCase
{
    private ReplyMachine $replyMachine;

    /**
     * @dataProvider provideValidMessage
     */
    public function testValidMessageGetsReply(string $text, string $expectedReply): void
    {
        $user = new User();
        $user->firstName = 'Chris';
        $message = new Message();
        $message->text = $text;
        $message->from = $user;
        $envelope = new Envelope();
        $envelope->message = $message;

        $reply = $this->replyMachine->findReply($envelope);
        static::assertStringStartsWith($expectedReply, $reply->getText());
    }

    /**
     * @return array<array{0: string, 1: string}>
     */
    public function provideValidMessage(): array
    {
        return [
            ['/start', 'Welcome to SymfonyConBot, Chris! :)'.PHP_EOL.'Use /help to see all commands.'],
            ['/help', '*SymfonyConBot Help*'.PHP_EOL.'This bot will help you to keep on track with all talks at SymfonyCon 2019 in Amsterdam.'],
            ['/countdown', '2 days, 12 hours and 45 minutes'],
        ];
    }

    public function testInvalidMessageGetsReply(): void
    {
        $message = new Message();
        $message->text = '/invalid';
        $envelope = new Envelope();
        $envelope->message = $message;

        $reply = $this->replyMachine->findReply($envelope);
        static::assertSame('Sorry, I didn\'t get that! Please try /help instead!', $reply->getText());
    }

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
}
