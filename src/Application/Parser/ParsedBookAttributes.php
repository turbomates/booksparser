<?php
declare(strict_types=1);

namespace App\Application\Parser;

final class ParsedBookAttributes
{
    public $author;
    public $title;
    public $language;

    public function __construct(string $author, string $title, string $language)
    {
        $this->author = $author;
        $this->title = $title;
        $this->language = $language;
    }
}