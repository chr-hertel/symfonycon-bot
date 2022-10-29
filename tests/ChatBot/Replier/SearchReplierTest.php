<?php

declare(strict_types=1);

namespace App\Tests\ChatBot\Replier;

use App\ChatBot\Replier\SearchReplier;
use App\ChatBot\Telegram\Data\Message;
use App\ChatBot\Telegram\Data\Update;
use App\SymfonyCon\Search;
use App\Tests\Templates;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Notifier\Message\ChatMessage;

final class SearchReplierTest extends TestCase
{
    use Templates;

    /** @var MockObject&Search */
    private MockObject $search;
    private SearchReplier $replier;

    protected function setUp(): void
    {
        $this->setUpTwig();
        $this->search = $this->getMockBuilder(Search::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->replier = new SearchReplier($this->search, $this->environment);
    }

    public function testSupportingTodayMessage(): void
    {
        $message = new Message();
        $message->text = '/search';
        $update = new Update();
        $update->message = $message;

        self::assertTrue($this->replier->supports($update));
    }

    public function testNotSupportingRandomMessage(): void
    {
        $message = new Message();
        $message->text = '/start';
        $update = new Update();
        $update->message = $message;

        self::assertFalse($this->replier->supports($update));
    }

    public function testSearchReplyWithoutQuery(): void
    {
        $message = new Message();
        $message->text = '/search ';
        $update = new Update();
        $update->message = $message;

        $this->search
            ->expects(self::never())
            ->method('search');

        $chatMessage = $this->replier->reply($update);

        self::assertInstanceOf(ChatMessage::class, $chatMessage);
        self::assertSame('Please add a search term, like "/search Symfony 6.2".', $chatMessage->getSubject());
    }

    public function testSearchReplyWithQuery(): void
    {
        $message = new Message();
        $message->text = '/search testing';
        $update = new Update();
        $update->message = $message;

        $this->search
            ->expects(self::once())
            ->method('search')
            ->with('testing');

        $chatMessage = $this->replier->reply($update);

        self::assertInstanceOf(ChatMessage::class, $chatMessage);
    }
}
