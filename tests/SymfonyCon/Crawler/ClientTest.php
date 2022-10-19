<?php

declare(strict_types=1);

namespace App\Tests\SymfonyCon\Crawler;

use App\SymfonyCon\Crawler\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ClientTest extends TestCase
{
    public function testGetSchedule(): void
    {
        $httpClient = new MockHttpClient($this->responseFactory(...));
        $client = new Client($httpClient);

        $expectedFile = dirname(__DIR__).'/fixtures/full-schedule.html';
        static::assertStringEqualsFile($expectedFile, $client->getSchedule());
    }

    private function responseFactory(string $method, string $url): ResponseInterface
    {
        static::assertSame('GET', $method);
        static::assertSame('https://live.symfony.com/2022-paris-con/schedule', $url);

        return new MockResponse((string) file_get_contents(dirname(__DIR__).'/fixtures/full-schedule.html'));
    }
}
