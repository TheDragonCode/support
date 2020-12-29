<?php

namespace Helldar\Support\Facades;

use DirectoryIterator;
use Helldar\Support\Exceptions\DirectoryNotFoundException;
use Helldar\Support\Traits\Deprecation;

/**
 * @deprecated 2.0: Namespace "Helldar\Support\Facades\Directory" is deprecated, use "Helldar\Support\Facades\Helpers\Filesystem\Directory" instead.
 */
class Directory
{
    use Deprecation;

    /**
     * @param  string  $path
     *
     * @throws \Helldar\Support\Exceptions\DirectoryNotFoundException
     *
     * @return \DirectoryIterator
     */
    public static function all(string $path): DirectoryIterator
    {
        static::deprecatedNamespace();

        if (! file_exists($path)) {
            throw new DirectoryNotFoundException($path);
        }

        return new DirectoryIterator($path);
    }

    /**
     * @param  string  $path
     *
     * @throws \Helldar\Support\Exceptions\DirectoryNotFoundException
     *
     * @return array
     */
    public static function names(string $path): array
    {
        static::deprecatedNamespace();

        $items = [];

        foreach (static::all($path) as $dir) {
            if ($dir->isDir() && ! $dir->isDot()) {
                $items[] = $dir->getFilename();
            }
        }

        sort($items);

        return $items;
    }

    public static function make(string $path, int $mode = 755): bool
    {
        static::deprecatedNamespace();

        if (! file_exists($path)) {
            return mkdir($path, $mode, true);
        }

        return true;
    }
}
