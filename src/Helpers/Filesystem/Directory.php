<?php

namespace Helldar\Support\Helpers\Filesystem;

use DirectoryIterator;
use Helldar\Support\Exceptions\DirectoryNotFoundException;

final class Directory
{
    public function all(string $path): DirectoryIterator
    {
        if ($this->doesntExist($path)) {
            throw new DirectoryNotFoundException($path);
        }

        return new DirectoryIterator($path);
    }

    public function names(string $path): array
    {
        $items = [];

        foreach ($this->all($path) as $directory) {
            if ($directory->isDir() && ! $directory->isDot()) {
                $items[] = $directory->getFilename();
            }
        }

        sort($items);

        return array_values($items);
    }

    public function make(string $path, int $mode = 755): bool
    {
        if ($this->doesntExist($path)) {
            return mkdir($path, $mode, true);
        }

        return true;
    }

    public function exists(string $path): bool
    {
        return file_exists($path) && is_dir($path);
    }

    public function doesntExist(string $path): bool
    {
        return ! $this->exists($path);
    }
}
