<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly string $baseUrl,
        private readonly string $token,
    ) {
    }

    /**
     * @phpstan-param list<array{command: string, description: string}> $commands
     */
    public function registerCommands(array $commands): void
    {
        $this->callEndpoint('setMyCommands', ['commands' => $commands]);
    }

    public function registerWebhook(): void
    {
        $url = $this->baseUrl.$this->urlGenerator->generate('webhook');

        $this->callEndpoint('setWebhook', ['url' => $url]);
    }

    /**
     * @phpstan-param array<string, mixed> $payload
     */
    private function callEndpoint(string $endpoint, array $payload): void
    {
        $endpoint = sprintf('https://api.telegram.org/bot%s/%s', $this->token, $endpoint);

        $this->httpClient->request('POST', $endpoint, ['json' => $payload]);
    }
}
