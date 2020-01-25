<?php

namespace Helldar\Support\Facades;

use function mb_strtolower;

/**
 * @see https://www.php.net/manual/ru/reserved.constants.php
 */
class OS
{
    public static function isUnix(): bool
    {
        return ! static::isWindows();
    }

    public static function isWindows(): bool
    {
        return static::family() === 'windows';
    }

    public static function isBSD(): bool
    {
        return static::family() === 'bsd';
    }

    public static function isDarwin(): bool
    {
        return static::family() === 'darwin';
    }

    public static function isSolaris(): bool
    {
        return static::family() === 'solaris';
    }

    public static function isLinux(): bool
    {
        return static::family() === 'linux';
    }

    public static function isUnknown(): bool
    {
        return static::family() === 'unknown';
    }

    public static function family(bool $is_lower = true): string
    {
        $family = PHP_MINOR_VERSION >= 2 ? PHP_OS_FAMILY : PHP_OS;

        return $is_lower ? mb_strtolower($family) : $family;
    }
}
