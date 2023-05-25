<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2023 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Tools;

use DragonCode\Support\Exceptions\UnknownStubFileException;
use DragonCode\Support\Helpers\Str;

class Stub
{
    public const JSON = 'json.stub';

    public const PHP = 'php.stub';

    /**
     * Replace the contents of the template file.
     *
     * @param string $stub
     * @param array $replace
     *
     * @throws \DragonCode\Support\Exceptions\UnknownStubFileException
     *
     * @return string
     */
    public static function replace(string $stub, array $replace): string
    {
        $content = static::get($stub);

        return Str::replaceFormat($content, $replace);
    }

    /**
     * Receive the contents of the template file.
     *
     * @param string $filename
     *
     * @throws \DragonCode\Support\Exceptions\UnknownStubFileException
     *
     * @return string
     */
    public static function get(string $filename): string
    {
        if ($path = static::path($filename)) {
            return file_get_contents($path);
        }

        throw new UnknownStubFileException($filename);
    }

    /**
     * Receive the path to the template file.
     *
     * @param string $filename
     *
     * @return string|null
     */
    protected static function path(string $filename): ?string
    {
        $path = static::isCustom($filename) ? $filename : __DIR__ . '/../../resources/stubs/' . $filename;

        return realpath($path);
    }

    /**
     * Returns a link to the template file.
     *
     * If the file exists under the specified link, it will return it,
     * otherwise it will search in the default folder.
     *
     * @param string $path
     *
     * @return bool
     */
    protected static function isCustom(string $path): bool
    {
        return file_exists($path);
    }
}
