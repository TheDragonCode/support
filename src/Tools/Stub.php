<?php

namespace Helldar\Support\Tools;

use Helldar\Support\Exceptions\UnknownStubFileException;

class Stub
{
    const CONFIG_FILE = 'config.stub';

    const LANG_JSON   = 'lang_json.stub';

    public static function get(string $filename): string
    {
        if ($path = self::path($filename)) {
            return \file_get_contents($path);
        }

        throw new UnknownStubFileException($filename);
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
