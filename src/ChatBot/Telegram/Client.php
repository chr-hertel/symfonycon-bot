<?php

declare(strict_types=1);

namespace App\ChatBot\Telegram;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    private $httpClient;
    private $urlGenerator;
    private $baseUrl;
    private $token;

    public function __construct(
        HttpClientInterface $httpClient,
        UrlGeneratorInterface $urlGenerator,
        string $baseUrl,
        string $token
    ) {
        $this->httpClient = $httpClient;
        $this->urlGenerator = $urlGenerator;
        $this->baseUrl = $baseUrl;
        $this->token = $token;
    }

    public function registerWebhook(): void
    {
        $endpoint = sprintf('https://api.telegram.org/bot%s/setWebhook', $this->token);
        $url = $this->baseUrl.$this->urlGenerator->generate('webhook');

        $this->httpClient->request('POST', $endpoint, ['json' => ['url' => $url]]);
    }
}
