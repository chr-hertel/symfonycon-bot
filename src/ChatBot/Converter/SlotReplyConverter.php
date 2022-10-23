<?php

declare(strict_types=1);

namespace App\ChatBot\Converter;

use App\ChatBot\MessageCollection;
use App\ChatBot\Reply\Reply;
use App\ChatBot\Reply\SlotReply;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\Button\InlineKeyboardButton;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\InlineKeyboardMarkup;
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

        $markup = (new InlineKeyboardMarkup())
            ->inlineKeyboard([(new InlineKeyboardButton('Back to listing'))->callbackData('back')]);

        $options = (new TelegramOptions())
            ->parseMode(TelegramOptions::PARSE_MODE_MARKDOWN)
            ->replyMarkup($markup)
            ->edit(608); // TODO: FUCKING WRONG ABSTRACTION ... && SYMFONY PR DEPENDENCY

        return MessageCollection::single(
            new ChatMessage((string) $reply->slot, $options),
        );
    }
}
