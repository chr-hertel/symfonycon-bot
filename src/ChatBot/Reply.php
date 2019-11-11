<?php

declare(strict_types=1);

namespace App\ChatBot;

class Reply
{
    private $text;
    private $markup;

    public function __construct(string $text, array $markup = [])
    {
        $this->text = $text;
        $this->markup = $markup;
    }

    public static function formatted(string $text): self
    {
        return new static('```'.PHP_EOL.$text.PHP_EOL.'```');
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getMarkup(): array
    {
        return $this->markup;
    }
}
