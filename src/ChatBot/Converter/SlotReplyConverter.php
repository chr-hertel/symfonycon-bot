<?php

declare(strict_types=1);

namespace App\ChatBot\Converter;

use App\ChatBot\MessageCollection;
use App\ChatBot\Reply\Reply;
use App\ChatBot\Reply\SlotReply;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\Message\ChatMessage;

final class SlotReplyConverter implements ReplyConverterInterface
{
    public function supports(Reply $reply): bool
    {
        return $reply instanceof SlotReply;
    }

    public function convert(Reply $reply): MessageCollection
    {
        assert($reply instanceof SlotReply);

        $options = (new TelegramOptions())
            ->parseMode(TelegramOptions::PARSE_MODE_MARKDOWN);

        return MessageCollection::single(
            new ChatMessage((string) $reply->slots, $options)
        );
    }
}
