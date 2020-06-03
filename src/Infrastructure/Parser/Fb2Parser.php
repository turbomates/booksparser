<?php

namespace App\Infrastructure\Parser;

use App\Application\Parser\MimeTypeParser;
use App\Application\Parser\ParsedBookAttributes;
use App\Infrastructure\File;
use Symfony\Component\DomCrawler\Crawler;

final class Fb2Parser implements MimeTypeParser
{
    public function supports(File $file): bool
    {
        return in_array($file->getMimeType(), self::supportedMimeTypes());
    }

    public function parse(File $file): ParsedBookAttributes
    {
        $xml = simplexml_load_string(file_get_contents($file->getPathname()));

        $author = [];
        foreach ($xml->description->{'title-info'}->author->children() as $part) {
            $author[] = (string)$part;
        }

        return new ParsedBookAttributes(
            implode(" ", $author),
            (string)$xml->description->{'title-info'}->{'book-title'},
            (string)$xml->description->{'title-info'}->lang
        );
    }

    public static function supportedMimeTypes(): array {
        return ["text/xml"];
    }
}