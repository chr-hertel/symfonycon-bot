<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebhookController
{
    /**
     * @Route("/chatbot", name="webhook", methods={"POST"})
     */
    public function connect(): Response
    {
        return Response::create();
    }
}
