<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Telegram\Data\Update;
use Symfony\Component\Notifier\Message\ChatMessage;

interface ReplierInterface
{
    public function supports(Update $update): bool;

    public function reply(Update $update): ChatMessage;
}
