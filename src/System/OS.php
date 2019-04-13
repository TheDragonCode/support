<?php

namespace Helldar\Support\System;

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

    public function isBSD()
    {
        return mb_strtolower(PHP_OS_FAMILY) == 'bsd';
    }

    public function isDarwin()
    {
        return mb_strtolower(PHP_OS_FAMILY) == 'darwin';
    }

    public function isSolaris()
    {
        return mb_strtolower(PHP_OS_FAMILY) == 'solaris';
    }

    public function isLinux()
    {
        return mb_strtolower(PHP_OS_FAMILY) == 'linux';
    }

    public function isUnknown()
    {
        return mb_strtolower(PHP_OS_FAMILY) == 'unknown';
    }
}
