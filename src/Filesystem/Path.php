<?php

namespace DragonCode\Support\Filesystem;

class Path
{
    public function dirname(string $path): string
    {
        return pathinfo($path, PATHINFO_DIRNAME);
    }

    public function basename(string $path): string
    {
        return pathinfo($path, PATHINFO_BASENAME);
    }

    public function extension(string $path): string
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    public function filename(string $path): string
    {
        return pathinfo($path, PATHINFO_FILENAME);
    }
}
