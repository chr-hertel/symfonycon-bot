<?php

declare(strict_types=1);

namespace App\ChatBot\Converter;

use App\ChatBot\MessageCollection;
use App\ChatBot\Reply\MarkdownReply;
use App\ChatBot\Reply\Reply;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\Message\ChatMessage;

final class MarkdownReplyConverter implements ReplyConverterInterface
{
    public function supports(Reply $reply): bool
    {
        return $reply instanceof MarkdownReply;
    }

    public function convert(Reply $reply): MessageCollection
    {
        assert($reply instanceof MarkdownReply);

        $options = (new TelegramOptions())
            ->parseMode(TelegramOptions::PARSE_MODE_MARKDOWN);

        return MessageCollection::single(
            new ChatMessage($reply->markdown, $options),
        );
    }
}
