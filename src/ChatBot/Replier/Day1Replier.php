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

final class Day1Replier extends CommandReplier
{
    public function __construct(private readonly Schedule $schedule, private readonly DayRenderer $renderer)
    {
    }

    public function getCommand(): string
    {
        return 'day1';
    }

    public function getDescription(): string
    {
        return 'Lists all talks of the first day';
    }

    public function reply(Update $update): ChatMessage
    {
        $slots = $this->schedule->day1();
        $message = $this->renderer->render('Schedule of Day 1', $slots);

        $button = (new InlineKeyboardButton('See Day 2'))->callbackData('/day2');
        $markup = (new InlineKeyboardMarkup())->inlineKeyboard([$button]);
        $options = (new TelegramOptions())->replyMarkup($markup);

        return new ChatMessage($message, $options);
    }
}
