<?php

namespace Helldar\Support\Helpers;

use Helldar\Support\Facades\Helpers\Str as StrHelper;

/**
 * @see https://www.php.net/manual/ru/reserved.constants.php
 */
final class OS
{
    public function isUnix(): bool
    {
        return ! $this->isWindows() && ! $this->isUnknown();
    }

    public function isWindows(): bool
    {
        return $this->family() === 'windows';
    }

    public function isBSD(): bool
    {
        return $this->family() === 'bsd';
    }

    public function isDarwin(): bool
    {
        return $this->family() === 'darwin';
    }

    public function isSolaris(): bool
    {
        return $this->family() === 'solaris';
    }

    public function isLinux(): bool
    {
        return $this->family() === 'linux';
    }

    public function isUnknown(): bool
    {
        return $this->family() === 'unknown';
    }

    public function family(bool $lower = true): string
    {
        $family = version_compare(PHP_VERSION, '7.2', '<') ? PHP_OS : PHP_OS_FAMILY;

        return $lower ? StrHelper::lower($family) : $family;
    }
}
