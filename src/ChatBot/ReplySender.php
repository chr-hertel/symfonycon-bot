<?php

declare(strict_types=1);

namespace App\ChatBot;

use App\ChatBot\Converter\ReplyConverterInterface;
use App\ChatBot\Reply\Reply;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

final class ReplySender
{
    /**
     * @param iterable<int, ReplyConverterInterface> $replyConverters
     */
    public function __construct(
        private readonly iterable $replyConverters,
        private readonly ChatterInterface $chatter,
    ) {
    }

    public function handle(Reply $reply): void
    {
        $messages = $this->convertReply($reply);

        /** @var ChatMessage $message */
        foreach ($messages as $message) {
            $this->injectRecipient($message, $reply->getRecipient());
            $this->chatter->send($message);
        }
    }

    private function convertReply(Reply $reply): MessageCollection
    {
        foreach ($this->replyConverters as $converter) {
            if ($converter->supports($reply)) {
                return $converter->convert($reply);
            }
        }

        throw new \RuntimeException(sprintf('Reply %s not supported', get_class($reply)));
    }

    private function injectRecipient(ChatMessage $message, string $chatId): void
    {
        $options = $message->getOptions() ?? new TelegramOptions();

        assert($options instanceof TelegramOptions);

        $options->chatId($chatId);

        $message->options($options);
    }
}
