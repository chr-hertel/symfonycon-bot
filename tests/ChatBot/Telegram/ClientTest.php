<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Telegram;

use App\ChatBot\Telegram\Client;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\CompiledUrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ClientTest extends TestCase
{
    public function testRegisterWebhook(): void
    {
        /** @var HttpClientInterface|MockObject $httpClient */
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient
            ->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://api.telegram.org/bottoken:1234567890/setWebhook',
                ['json' => ['url' => 'https://www.example.com/chatbot']]
            );

        $urlGenerator = new CompiledUrlGenerator(
            ['webhook' => [[], ['_controller' => 'App\\Controller\\WebhookController::connect'], [], [['text', '/chatbot']], [], []]],
            new RequestContext()
        );

        $client = new Client($httpClient, $urlGenerator, 'https://www.example.com', 'token:1234567890');
        $client->registerWebhook();
    }
}
