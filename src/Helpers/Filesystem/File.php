<?php

namespace Helldar\Support\Helpers\Filesystem;

use Helldar\Support\Exceptions\DirectoryNotFoundException;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;

class File
{
    public function all(string $path): array
    {
        if (Directory::doesntExist($path)) {
            throw new DirectoryNotFoundException($path);
        }

        $files = [];

        foreach (Directory::all($path) as $iterator) {
            if ($iterator->isFile()) {
                $files[] = $files;
            }
        }

        return $files;
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
}
