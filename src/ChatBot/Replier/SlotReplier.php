<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Reply\SlotReply;
use App\ChatBot\Reply\TextReply;
use App\ChatBot\Telegram\Data\CallbackQuery;
use App\ChatBot\Telegram\Data\Envelope;
use App\Repository\SlotRepository;

final class SlotReplier implements ReplierInterface
{
    public function __construct(private readonly SlotRepository $repository)
    {
    }

    public function supports(Envelope $envelope): bool
    {
        return $envelope->callbackQuery instanceof CallbackQuery && !empty($envelope->callbackQuery->data);
    }

    public function reply(Envelope $envelope): SlotReply|TextReply
    {
        assert(isset($envelope->callbackQuery->data));

        $id = $envelope->callbackQuery->data;

        if ('back' === $id) {
            return new TextReply('Return to listing');
        }

        $slot = $this->repository->find($id);

        if (null === $slot) {
            return new TextReply('Slot not found!');
        }

        return new SlotReply($slot);
    }
}
