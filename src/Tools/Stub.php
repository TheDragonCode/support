<?php

namespace Helldar\Support\Tools;

use Helldar\Support\Exceptions\UnknownStubFileException;
use Helldar\Support\Facades\Helpers\Str;

final class Stub
{
    public const PHP_ARRAY = 'php_array.stub';

    public const JSON = 'json.stub';

    /**
     * Replace the contents of the template file.
     *
     * @param  string  $stub_file
     * @param  array  $replace
     *
     * @throws \Helldar\Support\Exceptions\UnknownStubFileException
     *
     * @return string
     */
    public function replace(string $stub_file, array $replace): string
    {
        $content = $this->get($stub_file);

        return Str::replace($content, $replace);
    }

    /**
     * Receive the contents of the template file.
     *
     * @param  string  $filename
     *
     * @throws \Helldar\Support\Exceptions\UnknownStubFileException
     *
     * @return string
     */
    public function get(string $filename): string
    {
        if ($path = $this->path($filename)) {
            return file_get_contents($path);
        }

        throw new UnknownStubFileException($filename);
    }

    /**
     * Receive the path to the template file.
     *
     * @param  string  $filename
     *
     * @return string|null
     */
    protected function path(string $filename): ?string
    {
        return realpath(__DIR__ . '/../../resources/stubs/' . $filename);
    }
}
