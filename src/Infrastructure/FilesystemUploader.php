<?php

namespace App\Infrastructure;

use App\Application\Uploader;
use App\Domain\Book\FileLocation\FileLocation;
use App\Domain\Book\FileLocation\Filesystem;

class FilesystemUploader implements Uploader
{
    private $bookDir;
    public function __construct(string $bookDir)
    {
        $this->bookDir = $bookDir;
    }

    public function upload(File $file): FileLocation
    {
        $filename = $file->getBasename();
        $uploaded = $file->copy($this->bookDir, $filename);

        return new Filesystem($uploaded->getPathname());
    }
}