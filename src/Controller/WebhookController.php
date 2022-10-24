<?php

declare(strict_types=1);

namespace App\Controller;

use App\ChatBot\ChatBot;
use App\ChatBot\Telegram\Data\Update;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
final class WebhookController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ChatBot $chatBot,
    ) {
    }

    #[Route('/chatbot', name: 'webhook', methods: ['POST'])]
    public function connect(Request $request): Response
    {
        /** @var Update $update */
        $update = $this->serializer->deserialize($request->getContent(), Update::class, 'json', [
            DateTimeNormalizer::FORMAT_KEY => 'U',
        ]);

        $this->chatBot->consume($update);

        return new Response();
    }
}
