<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\ChatBot\Telegram\Client;
use App\Command\WebhookRegisterCommand;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class WebhookRegisterCommandTest extends WebTestCase
{
    /** @var Client|MockObject */
    private MockObject $telegramClient;
    /** @var CommandTester */
    private CommandTester $commandTester;

    public function testWebhookNotRegisteredWithoutConfirmation(): void
    {
        $this->telegramClient
            ->expects($this->never())
            ->method('registerWebhook');

        $this->commandTester->setInputs(['no']);
        $this->commandTester->execute([]);
    }

    public function testWebhookNotRegisteredOnNoInteraction(): void
    {
        $this->telegramClient
            ->expects($this->never())
            ->method('registerWebhook');

        $this->commandTester->execute([], ['interactive' => false]);
    }

    public function testWebhookRegisteredOnConfirmation(): void
    {
        $this->telegramClient
            ->expects($this->once())
            ->method('registerWebhook');

        $this->commandTester->setInputs(['yes']);
        $this->commandTester->execute([]);
    }

    protected function setUp(): void
    {
        $this->telegramClient = $this->createMock(Client::class);

        $command = new WebhookRegisterCommand($this->telegramClient);
        $this->commandTester = new CommandTester($command);
    }
}
