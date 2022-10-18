<?php

declare(strict_types=1);

namespace App\SymfonyCon\Crawler;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Client
{
    public function __construct(private readonly HttpClientInterface $httpClient)
    {
    }

    public function getSchedule(): string
    {
        $response = $this->httpClient->request('GET', 'https://live.symfony.com/2022-paris-con/schedule');

        return $response->getContent();
    }
}
