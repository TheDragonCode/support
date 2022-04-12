<?php

use DragonCode\Support\Facades\Facade;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Filesystem\Path;
use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Facades\Instances\Instance;

require __DIR__ . '/../vendor/autoload.php';

$base_path = __DIR__ . '/../src/Facades';
$docs_dir  = __DIR__ . '/../docs';

$names = File::names($base_path, fn (string $name) => Path::filename($name) !== Instance::basename(Facade::class), true);

foreach ($names as $name) {
    $directory = Path::dirname($name);
    $filename  = Path::filename($name);

    $path = $docs_dir . '/' . Str::lower($directory) . '/' . Str::lower($filename) . '.md';

    if (! File::exists($path)) {
        File::store($path, Str::of($name)->before('.php')->prepend('# '));
    }
}
