<?php

namespace DragonCode\Support\Filesystem;

use DragonCode\Support\Facades\Helpers\Str;

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
        return Str::lower(pathinfo($path, PATHINFO_EXTENSION));
    }

    public function filename(string $path): string
    {
        return pathinfo($path, PATHINFO_FILENAME);
    }
}
