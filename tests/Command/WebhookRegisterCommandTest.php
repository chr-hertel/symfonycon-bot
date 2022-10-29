<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\ChatBot\Telegram\Client;
use App\Command\WebhookRegisterCommand;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @group functional
 */
final class WebhookRegisterCommandTest extends KernelTestCase
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
        self::assertStringContainsString('Registering Telegram Webhook', $output);
        self::assertStringContainsString('Really want to replace the webhook?', $output);
        self::assertStringNotContainsString('Done', $output);

        self::assertSame(0, $this->commandTester->getStatusCode());
    }

    public function testWebhookNotRegisteredOnNoInteraction(): void
    {
        $this->telegramClient
            ->expects($this->never())
            ->method('registerWebhook');

        $this->commandTester->execute([], ['interactive' => false]);

        $output = $this->commandTester->getDisplay();
        self::assertStringContainsString('Registering Telegram Webhook', $output);
        self::assertStringNotContainsString('Really want to replace the webhook?', $output);
        self::assertStringNotContainsString('Done', $output);

        self::assertSame(0, $this->commandTester->getStatusCode());
    }

    public function testWebhookRegisteredOnConfirmation(): void
    {
        $this->telegramClient
            ->expects($this->once())
            ->method('registerWebhook');

        $this->commandTester->setInputs(['yes']);
        $this->commandTester->execute([]);

        $output = $this->commandTester->getDisplay();
        self::assertStringContainsString('Registering Telegram Webhook', $output);
        self::assertStringContainsString('Really want to replace the webhook?', $output);
        self::assertStringContainsString('Done', $output);

        self::assertSame(0, $this->commandTester->getStatusCode());
    }

    protected function setUp(): void
    {
        $this->telegramClient = $this->createMock(Client::class);

        $command = new WebhookRegisterCommand($this->telegramClient);
        $this->commandTester = new CommandTester($command);
    }
}
