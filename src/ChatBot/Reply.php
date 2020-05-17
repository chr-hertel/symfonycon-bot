<?php

declare(strict_types=1);

namespace App\ChatBot;

class Reply
{
    private string $text;
    private array $markup;

    public function __construct(string $text, array $markup = [])
    {
        $this->text = $text;
        $this->markup = $markup;
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
