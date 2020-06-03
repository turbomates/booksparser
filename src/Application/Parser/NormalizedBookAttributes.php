<?php
declare(strict_types=1);

namespace App\Application\Parser;

use App\Domain\Book\Author;
use App\Domain\Book\Language;

final class NormalizedBookAttributes
{
    public $author;
    public $title;
    public $language;

    public function __construct(Author $author, string $title, Language $language)
    {
        $this->author = $author;
        $this->title = $title;
        $this->language = $language;
    }
}