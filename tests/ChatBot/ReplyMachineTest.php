<?php

declare(strict_types=1);

namespace App\Tests\ChatBot;

use App\ChatBot\Replier\CountdownReplier;
use App\ChatBot\Replier\HelpReplier;
use App\ChatBot\Replier\StartReplier;
use App\ChatBot\ReplyMachine;
use App\ChatBot\Telegram\Data\Message;
use App\ChatBot\Telegram\Data\Update;
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
        $update = new Update();
        $update->message = $message;

        $chatMessage = $this->replyMachine->findReply($update);
        self::assertStringStartsWith($expectedReply, $chatMessage->getSubject());
    }

    /**
     * @return array<array{0: string, 1: string}>
     */
    public function provideValidMessage(): array
    {
        return [
            ['/start', '<b>Welcome to SymfonyConBot, Chris! :)</b>'.PHP_EOL.PHP_EOL.'Use /help to see all commands.'],
            ['/help', '<b>SymfonyConBot Help</b>'.PHP_EOL.'This bot will help you to keep on track with all talks at SymfonyCon Disneyland Paris 2022.'],
            ['/countdown', 'Only <b>2 days, 12 hours and 45 minutes</b> until SymfonyCon starts.'],
        ];
    }

    public function testInvalidMessageGetsReply(): void
    {
        $message = new Message();
        $message->text = '/invalid';
        $update = new Update();
        $update->message = $message;

        $chatMessage = $this->replyMachine->findReply($update);
        self::assertSame('<b>Sorry, I didn\'t get that!</b>'.PHP_EOL.PHP_EOL.'Please try /help instead!', $chatMessage->getSubject());
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
