<?php

namespace Helldar\Support\Tools;

use Helldar\Support\Exceptions\UnknownStubFileException;

final class Stub
{
    public const PHP_ARRAY = 'php_array.stub';

    public const JSON = 'json.stub';

    public function replace(string $filename, array $replace): string
    {
        $content = $this->get($filename);

        $keys   = array_keys($replace);
        $values = array_values($replace);

        return str_replace($keys, $values, $content);
    }

    public function get(string $filename): string
    {
        if ($path = $this->path($filename)) {
            return file_get_contents($path);
        }

        throw new UnknownStubFileException($filename);
    }

    protected function path(string $filename): ?string
    {
        return realpath(__DIR__ . '/../stubs/' . $filename);
    }
}
