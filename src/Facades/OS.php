<?php

namespace Helldar\Support\Facades;

/**
 * @see https://www.php.net/manual/ru/reserved.constants.php
 */
class OS
{
    public static function isWindows(): bool
    {
        return self::family() == 'windows';
    }

    public static function isUnix(): bool
    {
        return !self::isWindows();
    }

    public static function isBSD(): bool
    {
        return self::family() == 'bsd';
    }

    public static function isDarwin(): bool
    {
        return self::family() == 'darwin';
    }

    public static function isSolaris(): bool
    {
        return self::family() == 'solaris';
    }

    public static function isLinux(): bool
    {
        return self::family() == 'linux';
    }

    public static function isUnknown(): bool
    {
        return self::family() == 'unknown';
    }

    public static function family(bool $is_lower = true): string
    {
        $family = PHP_MINOR_VERSION >= 2 ? PHP_OS_FAMILY : PHP_OS;

        return $is_lower ? \mb_strtolower($family) : $family;
    }
}
