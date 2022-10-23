<?php

declare(strict_types=1);

namespace App\ChatBot\Reply;

use App\SymfonyCon\SlotCollection;

final class SlotCollectionReply extends Reply
{
    public function __construct(public readonly string $headline, public readonly SlotCollection $slots)
    {
    }
}
