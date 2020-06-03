<?php


namespace App\Infrastructure;

use App\Application\Downloader;
use App\Domain\Book\FileLocation\FileLocation;

class FilesystemDownloader implements Downloader
{
    public function download(FileLocation $location): File
    {
        return new File($location->path());
    }

}