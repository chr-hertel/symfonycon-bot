<?php

declare(strict_types=1);

namespace App\ChatBot\Converter;

use App\ChatBot\MessageCollection;
use App\ChatBot\Reply\Reply;
use App\ChatBot\Reply\SlotCollectionReply;
use App\Entity\Slot;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\Button\InlineKeyboardButton;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\InlineKeyboardMarkup;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\Message\ChatMessage;

final class SlotCollectionReplyConverter implements ReplyConverterInterface
{
    public function supports(Reply $reply): bool
    {
        return $reply instanceof SlotCollectionReply;
    }

    public function convert(Reply $reply): MessageCollection
    {
        assert($reply instanceof SlotCollectionReply);

        if (0 === count($reply->slots)) {
            return MessageCollection::single(
                new ChatMessage('Nothing found!')
            );
        }

        $options = (new TelegramOptions())
            ->parseMode(TelegramOptions::PARSE_MODE_MARKDOWN);

        $messages = MessageCollection::single(
            new ChatMessage(sprintf('*%s*', $reply->headline), $options)
        );

        foreach ($reply->slots->inGroups() as $group) {
            $inlineKeyboard = new InlineKeyboardMarkup();
            array_walk($group, static function (Slot $slot) use ($inlineKeyboard) {
                $button = (new InlineKeyboardButton($slot->getTitle()))
                    ->callbackData($slot->getId());

                $inlineKeyboard->inlineKeyboard([$button]);
            });

            $options = (new TelegramOptions())
                ->replyMarkup($inlineKeyboard);

            /** @var Slot $slot */
            $slot = reset($group);
            $label = $slot->getTimeSpan();

            $messages[] = new ChatMessage($label, $options);
        }

        return $messages;
    }
}
