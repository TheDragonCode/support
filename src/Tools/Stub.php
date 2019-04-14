<?php

namespace Helldar\Support\Tools;

use Helldar\Support\Exceptions\StubNotExists;

class Stub
{
    const ARRAY_STUB = 'array.stub';

    public static function get(string $filename): string
    {
        if ($path = self::path($filename)) {
            return \file_get_contents($path);
        }

        throw new StubNotExists($filename);
    }

    public static function replace(string $filename, array $replace): string
    {
        $content = self::get($filename);

        $keys   = \array_keys($replace);
        $values = \array_values($replace);

        return \str_replace($keys, $values, $content);
    }

    private static function path(string $filename): ?string
    {
        $path = __DIR__ . '/../stubs/' . $filename;

        return \realpath($path);
    }
}
