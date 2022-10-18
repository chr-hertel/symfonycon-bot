<?php

declare(strict_types=1);

namespace App\Controller;

use App\ChatBot\Telegram\Data\Envelope;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class WebhookController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly MessageBusInterface $messageBus,
    ) {
    }

    #[Route('/chatbot', name: 'webhook', methods: ['POST'])]
    public function connect(Request $request): Response
    {
        /** @var Envelope $envelope */
        $envelope = $this->serializer->deserialize($request->getContent(), Envelope::class, 'json', [
            'datetime_format' => 'U',
        ]);

        $this->messageBus->dispatch($envelope);

        return new Response();
    }
}
