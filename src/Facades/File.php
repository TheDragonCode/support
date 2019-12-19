<?php

namespace Helldar\Support\Facades;

use function file_exists;
use function file_put_contents;
use function mkdir;
use function pathinfo;

class File
{
    public static function store(string $path, string $content)
    {
        $directory = pathinfo($path, PATHINFO_DIRNAME);

        static::makeDirectory($directory);

        file_put_contents($path, $content);
    }

    public static function makeDirectory(string $path): bool
    {
        if (!file_exists($path)) {
            return mkdir($path, 755, true);
        }

        return true;
    }
}
