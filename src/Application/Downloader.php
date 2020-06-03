<?php

namespace App\Application;

use App\Domain\Book\FileLocation\FileLocation;
use App\Infrastructure\File;

interface Downloader
{
    public function download(FileLocation $location): File;
}