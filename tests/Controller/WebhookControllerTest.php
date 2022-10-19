<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\ConferenceFixtures;
use App\Tests\SchemaSetup;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class WebhookControllerTest extends WebTestCase
{
    use SchemaSetup;
    use ConferenceFixtures;

    private KernelBrowser $client;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        /** @var Registry $registry */
        $registry = $this->client->getContainer()->get('doctrine');
        /** @var EntityManagerInterface $manager */
        $manager = $registry->getManager();
        $this->entityManager = $manager;

        $this->setUpSchema();
        $this->setUpFixtures();
    }

    public function testSuccessfulStartMessage(): void
    {
        $message = (string) file_get_contents(__DIR__.'/fixtures/start.json');

        $this->client->request('POST', '/chatbot', [], [], [], $message);

        self::assertResponseIsSuccessful();
    }
}
