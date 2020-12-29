<?php

namespace Helldar\Support\Facades;

use Helldar\Support\Traits\Deprecation;

/**
 * @see https://www.php.net/manual/ru/reserved.constants.php
 * @deprecated 2.0: Namespace "Helldar\Support\Facades\Is" is deprecated, use "Helldar\Support\Facades\Helpers\Is" instead.
 */
class OS
{
    use Deprecation;

    public static function isUnix(): bool
    {
        static::deprecatedNamespace();

        return ! static::isWindows();
    }

    public static function isWindows(): bool
    {
        static::deprecatedNamespace();

        return static::family() === 'windows';
    }

    public static function isBSD(): bool
    {
        static::deprecatedNamespace();

        return static::family() === 'bsd';
    }

    public static function isDarwin(): bool
    {
        static::deprecatedNamespace();

        return static::family() === 'darwin';
    }

    public static function isSolaris(): bool
    {
        static::deprecatedNamespace();

        return static::family() === 'solaris';
    }

    public static function isLinux(): bool
    {
        static::deprecatedNamespace();

        return static::family() === 'linux';
    }

    public static function isUnknown(): bool
    {
        static::deprecatedNamespace();

        return static::family() === 'unknown';
    }

    public static function family(bool $is_lower = true): string
    {
        static::deprecatedNamespace();

        $family = version_compare(PHP_VERSION, '7.2', '<') ? PHP_OS : PHP_OS_FAMILY;

        return $is_lower ? mb_strtolower($family) : $family;
    }
}
