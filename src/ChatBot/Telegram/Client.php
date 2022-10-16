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

    public function registerWebhook(): void
    {
        $endpoint = sprintf('https://api.telegram.org/bot%s/setWebhook', $this->token);
        $url = $this->baseUrl.$this->urlGenerator->generate('webhook');

        $this->httpClient->request('POST', $endpoint, ['json' => ['url' => $url]]);
    }
}
