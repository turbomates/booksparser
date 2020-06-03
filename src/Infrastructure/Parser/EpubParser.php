<?php

namespace App\Infrastructure\Parser;

use App\Application\Parser\MimeTypeParser;
use App\Application\Parser\ParsedBookAttributes;
use App\Infrastructure\File;

final class EpubParser implements MimeTypeParser
{
    public function supports(File $file): bool
    {
        return in_array($file->getMimeType(), self::supportedMimeTypes());
    }

    public function parse(File $file): ParsedBookAttributes
    {
        throw new \Exception('Not implemented');
    }

    public static function supportedMimeTypes(): array {
        return ["application/epub+zip"];
    }
}