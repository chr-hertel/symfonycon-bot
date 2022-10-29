<?php

declare(strict_types=1);

namespace App\Tests\SymfonyCon;

use App\SymfonyCon\Crawler;
use App\SymfonyCon\Crawler\Client;
use App\SymfonyCon\Crawler\Parser;
use App\Tests\SchemaSetup;
use App\Tests\TestDatabase;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class CrawlerTest extends TestCase
{
    use TestDatabase;
    use SchemaSetup;

    protected function setUp(): void
    {
        $this->setUpDatabase();
        $this->setUpSchema();
    }

    public function testFetchData(): void
    {
        $httpClient = new MockHttpClient($this->responseFactory(...));
        $client = new Client($httpClient);
        $crawler = new Crawler($client, new Parser(), $this->entityManager);

        $crawler->loadSchedule();

        self::assertSame(27, $this->repository->count([]));
    }

    private function responseFactory(string $method, string $url): ResponseInterface
    {
        self::assertSame('GET', $method);
        self::assertSame('https://live.symfony.com/2022-paris-con/schedule', $url);

        return new MockResponse((string) file_get_contents(__DIR__.'/fixtures/full-schedule.html'));
    }
}
