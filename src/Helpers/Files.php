<?php

namespace Helldar\Support\Helpers;

class Files
{
    public static function store(string $path, string $content)
    {
        $directory = \pathinfo($path, PATHINFO_DIRNAME);

        self::makeDirectory($directory);

        \file_put_contents($path, $content);
    }

    public static function makeDirectory(string $path): bool
    {
        if (!\file_exists($path)) {
            return \mkdir($path, 755, true);
        }

        return true;
    }
}
