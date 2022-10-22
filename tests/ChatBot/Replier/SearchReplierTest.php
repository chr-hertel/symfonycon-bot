<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Replier;

use App\ChatBot\Replier\SearchReplier;
use App\ChatBot\Reply;
use App\ChatBot\Telegram\Data\Envelope;
use App\ChatBot\Telegram\Data\Message;
use App\SymfonyCon\Search;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class SearchReplierTest extends TestCase
{
    /** @var MockObject&Search */
    private MockObject $search;
    private SearchReplier $replier;

    protected function setUp(): void
    {
        $this->search = $this->getMockBuilder(Search::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->replier = new SearchReplier($this->search);
    }

    public function testSupportingTodayMessage(): void
    {
        $message = new Message();
        $message->text = '/search';
        $envelope = new Envelope();
        $envelope->message = $message;

        static::assertTrue($this->replier->supports($envelope));
    }

    public function testNotSupportingRandomMessage(): void
    {
        $message = new Message();
        $message->text = '/start';
        $envelope = new Envelope();
        $envelope->message = $message;

        static::assertFalse($this->replier->supports($envelope));
    }

    public function testSearchReplyWithoutQuery(): void
    {
        $message = new Message();
        $message->text = '/search ';
        $envelope = new Envelope();
        $envelope->message = $message;

        $this->search
            ->expects(static::never())
            ->method('search');

        $reply = $this->replier->reply($envelope);

        static::assertInstanceOf(Reply::class, $reply);
        static::assertSame('Please add a search term, like "/search Symfony 6.2".', $reply->getText());
    }

    public function testSearchReplyWithQuery(): void
    {
        $message = new Message();
        $message->text = '/search testing';
        $envelope = new Envelope();
        $envelope->message = $message;

        $this->search
            ->expects(static::once())
            ->method('search')
            ->with('testing');

        $reply = $this->replier->reply($envelope);

        static::assertInstanceOf(Reply::class, $reply);
    }
}
