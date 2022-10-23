<?php

declare(strict_types=1);

namespace App\ChatBot\Reply;

use App\Entity\Slot;

final class SlotReply extends Reply
{
    public function __construct(public readonly Slot $slot)
    {
    }
}
