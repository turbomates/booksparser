<?php


namespace App\Application\Parser;


use App\Infrastructure\File;

final class Parser
{
    private $mimeTypeParsers;

    public function addMimeTypeParser(MimeTypeParser $mimeTypeParser) {
        $this->mimeTypeParsers[] = $mimeTypeParser;
    }

    public function parse(File $file): ParsedBookAttributes
    {
        foreach ($this->mimeTypeParsers as $parser) {
            if ($parser->supports($file)) {
                return $parser->parse($file);
            }
        }
        throw new \Exception("Could not find suitable parser for: " . $file->getMimeType());
    }
}