<?php

namespace App\Application;

use App\Domain\Book\FileLocation\FileLocation;
use App\Infrastructure\File;

interface Uploader
{
    public function upload(File $file): FileLocation;
}