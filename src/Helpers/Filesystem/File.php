<?php

namespace Helldar\Support\Helpers\Filesystem;

use DirectoryIterator;
use ErrorException;
use Helldar\Support\Exceptions\DirectoryNotFoundException;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;

class File
{
    /**
     * @param  string  $path
     *
     * @throws \Helldar\Support\Exceptions\DirectoryNotFoundException
     *
     * @return array|\SplFileInfo[]
     */
    public function all(string $path): array
    {
        if (Directory::doesntExist($path)) {
            throw new DirectoryNotFoundException($path);
        }

        $dirs  = new DirectoryIterator($path);
        $items = [];

        foreach ($dirs as $item) {
            if ($item->isFile()) {
                $items[] = $item->current();
            }
        }

        return $items;
    }

    public function store(string $path, string $content): void
    {
        Directory::make(pathinfo($path, PATHINFO_DIRNAME));

        file_put_contents($path, $content);
    }

    public function exists(string $path): bool
    {
        return file_exists($path) && is_file($path);
    }

    /**
     * @param  string|string[]  $paths
     *
     * @return bool
     */
    public function delete($paths): bool
    {
        $paths = Arr::wrap($paths);

        $success = true;

        foreach ($paths as $path) {
            try {
                if (! @unlink($path)) {
                    $success = false;
                }
            }
            catch (ErrorException $e) {
                $success = false;
            }
        }

        return $success;
    }
}
