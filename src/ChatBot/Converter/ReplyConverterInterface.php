<?php

declare(strict_types=1);

namespace App\ChatBot\Converter;

use App\ChatBot\MessageCollection;
use App\ChatBot\Reply\Reply;

interface ReplyConverterInterface
{
    public function supports(Reply $reply): bool;

    public function convert(Reply $reply): MessageCollection;
}
