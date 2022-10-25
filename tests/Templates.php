<?php

declare(strict_types=1);

namespace App\Tests;

use App\Twig\ShortExtension;
use Keiko\Uuid\Shortener\Dictionary;
use Keiko\Uuid\Shortener\Shortener;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

trait Templates
{
    private Environment $environment;

    protected function setUpTwig(): void
    {
        $this->environment = new Environment(new FilesystemLoader(dirname(__DIR__).'/templates'));
        $this->environment->addExtension(new ShortExtension(Shortener::make(Dictionary::createUnmistakable())));
    }
}
