<?php

namespace Helldar\Support\Helpers;

/**
 * @see https://www.php.net/manual/ru/reserved.constants.php
 */
class OS
{
    public static function isWindows()
    {
        return mb_strtolower(PHP_OS_FAMILY) == 'windows';
    }

    public static function isUnix()
    {
        return !self::isWindows();
    }

    public static function isBSD()
    {
        return mb_strtolower(PHP_OS_FAMILY) == 'bsd';
    }

    public static function isDarwin()
    {
        return mb_strtolower(PHP_OS_FAMILY) == 'darwin';
    }

    public static function isSolaris()
    {
        return mb_strtolower(PHP_OS_FAMILY) == 'solaris';
    }

    public static function isLinux()
    {
        return mb_strtolower(PHP_OS_FAMILY) == 'linux';
    }

    public static function isUnknown()
    {
        return mb_strtolower(PHP_OS_FAMILY) == 'unknown';
    }
}
