<?php

declare(strict_types=1);

namespace App\Tests\SymfonyCon;

use App\SymfonyCon\Crawler;
use App\SymfonyCon\Crawler\Client;
use App\SymfonyCon\Crawler\Parser;
use App\Tests\TestDatabase;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class CrawlerTest extends TestCase
{
    use TestDatabase;

    public function testFetchData(): void
    {
        $httpClient = new MockHttpClient($this->responseFactory(...));
        $client = new Client($httpClient);
        $crawler = new Crawler($client, new Parser(), $this->entityManager);

        $crawler->loadSchedule();

        static::assertSame(45, $this->repository->count([]));
    }

    private function responseFactory(string $method, string $url): ResponseInterface
    {
        static::assertSame('GET', $method);
        static::assertSame('https://live.symfony.com/2022-paris-con/schedule', $url);

        return new MockResponse((string) file_get_contents(__DIR__.'/fixtures/full-schedule.html'));
    }
}
