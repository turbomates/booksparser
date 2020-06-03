<?php

namespace App\Infrastructure;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

final class File extends \Symfony\Component\HttpFoundation\File\File
{
    public function copy(string $directory, string $name = null)
    {
        $target = $this->getTargetFile($directory, $name);

        set_error_handler(function ($type, $msg) use (&$error) { $error = $msg; });
        $coped = copy($this->getPathname(), $target);
        restore_error_handler();
        if (!$coped) {
            throw new FileException(sprintf('Could not move the file "%s" to "%s" (%s).', $this->getPathname(), $target, strip_tags($error)));
        }

        @chmod($target, 0666 & ~umask());

        return $target;
    }
}