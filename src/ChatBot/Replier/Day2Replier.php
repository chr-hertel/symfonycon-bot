<?php

declare(strict_types=1);

namespace App\ChatBot\Replier;

use App\ChatBot\Replier\Renderer\DayRenderer;
use App\ChatBot\Telegram\Data\Update;
use App\SymfonyCon\Schedule;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\Button\InlineKeyboardButton;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\InlineKeyboardMarkup;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\Message\ChatMessage;

final class Day2Replier extends CommandReplier
{
    public function __construct(private readonly Schedule $schedule, private readonly DayRenderer $renderer)
    {
    }

    public function getCommand(): string
    {
        return 'day2';
    }

    public function getDescription(): string
    {
        return 'Lists all talks of the second day';
    }

    public function reply(Update $update): ChatMessage
    {
        $slots = $this->schedule->day2();
        $message = $this->renderer->render('Schedule of Day 2', $slots);

        $button = (new InlineKeyboardButton('See Day 1'))->callbackData('/day1');
        $markup = (new InlineKeyboardMarkup())->inlineKeyboard([$button]);
        $options = (new TelegramOptions())->replyMarkup($markup);

        if ($update->isCallback()) {
            $options->edit($update->getMessage()->messageId);
        }

        return new ChatMessage($message, $options);
    }
}
