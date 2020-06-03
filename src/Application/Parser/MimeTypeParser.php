<?php

namespace App\Application\Parser;

use App\Infrastructure\File;

interface MimeTypeParser
{
    public function supports(File $file): bool;
    public function parse(File $file): ParsedBookAttributes;
    public static function supportedMimeTypes(): array;
}