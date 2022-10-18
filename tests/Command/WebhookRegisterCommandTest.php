<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\ChatBot\Telegram\Client;
use App\Command\WebhookRegisterCommand;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class WebhookRegisterCommandTest extends WebTestCase
{
    /** @var Client|MockObject */
    private MockObject $telegramClient;
    private CommandTester $commandTester;

    public function testWebhookNotRegisteredWithoutConfirmation(): void
    {
        $this->telegramClient
            ->expects($this->never())
            ->method('registerWebhook');

        $this->commandTester->setInputs(['no']);
        $this->commandTester->execute([]);

        $output = $this->commandTester->getDisplay();
        static::assertStringContainsString('Registering Telegram Webhook', $output);
        static::assertStringContainsString('Really want to replace the webhook?', $output);
        static::assertStringNotContainsString('Done', $output);

        static::assertSame(0, $this->commandTester->getStatusCode());
    }

    public function testWebhookNotRegisteredOnNoInteraction(): void
    {
        $this->telegramClient
            ->expects($this->never())
            ->method('registerWebhook');

        $this->commandTester->execute([], ['interactive' => false]);

        $output = $this->commandTester->getDisplay();
        static::assertStringContainsString('Registering Telegram Webhook', $output);
        static::assertStringNotContainsString('Really want to replace the webhook?', $output);
        static::assertStringNotContainsString('Done', $output);

        static::assertSame(0, $this->commandTester->getStatusCode());
    }

    public function testWebhookRegisteredOnConfirmation(): void
    {
        $this->telegramClient
            ->expects($this->once())
            ->method('registerWebhook');

        $this->commandTester->setInputs(['yes']);
        $this->commandTester->execute([]);

        $output = $this->commandTester->getDisplay();
        static::assertStringContainsString('Registering Telegram Webhook', $output);
        static::assertStringContainsString('Really want to replace the webhook?', $output);
        static::assertStringContainsString('Done', $output);

        static::assertSame(0, $this->commandTester->getStatusCode());
    }

    protected function setUp(): void
    {
        $this->telegramClient = $this->createMock(Client::class);

        $command = new WebhookRegisterCommand($this->telegramClient);
        $this->commandTester = new CommandTester($command);
    }
}
