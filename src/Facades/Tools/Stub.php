<?php

namespace Helldar\Support\Facades\Tools;

use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Tools\Stub as Tool;

/**
 * @method static string replace(string $stub_file, array $replace)
 * @method static string get(string $filename)
 */
final class Stub extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Tool::class;
    }
}
