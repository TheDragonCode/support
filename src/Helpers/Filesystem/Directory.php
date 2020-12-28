<?php

namespace Helldar\Support\Helpers\Filesystem;

use DirectoryIterator;
use FilesystemIterator;
use Helldar\Support\Exceptions\DirectoryNotFoundException;
use Helldar\Support\Facades\Helpers\Filesystem\File;
use Helldar\Support\Facades\Helpers\Instance;
use SplFileInfo;

final class Directory
{
    /**
     * @param  string  $path
     *
     * @throws \Helldar\Support\Exceptions\DirectoryNotFoundException
     *
     * @return DirectoryIterator
     */
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

    public function delete(string $path): bool
    {
        if (! $this->isDirectory($path)) {
            throw new DirectoryNotFoundException($path);
        }

        $items = new FilesystemIterator($path);

        $success = true;

        foreach ($items as $item) {
            $item->isDir() && ! $item->isLink()
                ? $this->delete($item->getPathname())
                : File::delete($item->getPathname());
        }

        @rmdir($path);

        return $success;
    }

    public function exists(string $path): bool
    {
        return file_exists($path) && is_dir($path);
    }

    public function doesntExist(string $path): bool
    {
        return ! $this->exists($path);
    }

    /**
     * @param  \SplFileInfo|DirectoryIterator|string  $value
     *
     * @return bool
     */
    public function isDirectory($value): bool
    {
        if (Instance::of($value, [SplFileInfo::class, DirectoryIterator::class])) {
            return $value->isDir();
        }

        return is_dir($value);
    }
}
