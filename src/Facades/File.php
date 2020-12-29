<?php

namespace Helldar\Support\Facades;

use Helldar\Support\Traits\Deprecation;

/**
 * @deprecated 2.0: Namespace "Helldar\Support\Facades\File" is deprecated, use "Helldar\Support\Facades\Helpers\Filesystem\File" instead.
 */
class File
{
    use Deprecation;

    public static function all(string $path): array
    {
        static::deprecatedNamespace();
        static::deprecatedRenameMethod('File::all', 'Directory::all');

        $files = [];

        foreach (Directory::all($path) as $iterator) {
            if ($iterator->isFile()) {
                $files[] = $files;
            }
        }

        return $files;
    }

    public static function store(string $path, string $content)
    {
        static::deprecatedNamespace();
        static::deprecatedMethodParameters(__FUNCTION__);

        Directory::make(pathinfo($path, PATHINFO_DIRNAME));

        file_put_contents($path, $content);
    }

    /**
     * @deprecated Use Helldar\Support\Facades\Directory::make() instead.
     *
     * @param  string  $path
     *
     * @return bool
     */
    public static function makeDirectory(string $path): bool
    {
        static::deprecatedNamespace();
        static::deprecatedRenameMethod('File::makeDirectory', 'Directory::make');

        return Directory::make($path);
    }
}
