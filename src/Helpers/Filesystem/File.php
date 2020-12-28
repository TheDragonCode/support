<?php

namespace Helldar\Support\Helpers\Filesystem;

use ErrorException;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Filesystem\Directory;

class File
{
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
