<?php

declare(strict_types=1);

namespace App\ChatBot\Converter;

use App\ChatBot\MessageCollection;
use App\ChatBot\Reply\Reply;
use App\ChatBot\Reply\TextReply;
use Symfony\Component\Notifier\Message\ChatMessage;

final class TextReplyConverter implements ReplyConverterInterface
{
    public function supports(Reply $reply): bool
    {
        return $reply instanceof TextReply;
    }

    public function convert(Reply $reply): MessageCollection
    {
        assert($reply instanceof TextReply);

        return MessageCollection::single(
            new ChatMessage($reply->text)
        );
    }
}
