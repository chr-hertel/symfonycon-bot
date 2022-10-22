<?php

declare(strict_types=1);

namespace App\ChatBot;

use Symfony\Component\Notifier\Message\ChatMessage;

/**
 * @extends \ArrayIterator<int, ChatMessage>
 */
final class MessageCollection extends \ArrayIterator
{
    private function __construct(ChatMessage ...$messages)
    {
        parent::__construct(array_values($messages));
    }

    /**
     * @param array<ChatMessage> $messages
     */
    public static function array(array $messages): self
    {
        return new self(...$messages);
    }

    public static function single(ChatMessage $message): self
    {
        return new self($message);
    }

    public static function empty(): self
    {
        return new self();
    }
}
