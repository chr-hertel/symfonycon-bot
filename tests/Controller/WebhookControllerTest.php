<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class WebhookControllerTest extends WebTestCase
{
    public function testSuccessfulStartMessage(): void
    {
        $message = file_get_contents(__DIR__.'/fixtures/start.json');

        if (false === $message) {
            static::markTestSkipped('Fixture file not readable.');
        }

        $client = static::createClient();
        $client->request('POST', '/chatbot', [], [], [], $message);

        self::assertResponseIsSuccessful();
    }
}
