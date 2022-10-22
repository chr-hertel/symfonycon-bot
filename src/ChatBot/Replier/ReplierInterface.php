<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Reply\Reply;
use App\ChatBot\Telegram\Data\Envelope;

interface ReplierInterface
{
    public function supports(Envelope $envelope): bool;

    public function reply(Envelope $envelope): Reply;
}
