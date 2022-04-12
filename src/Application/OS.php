<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Application;

use DragonCode\Support\Facades\Helpers\Str;

/**
 * @see https://www.php.net/manual/ru/reserved.constants.php
 */
class OS
{
    /**
     * Determines if a system is of type Unix.
     *
     * @return bool
     */
    public function isUnix(): bool
    {
        return ! $this->isWindows() && ! $this->isUnknown();
    }

    /**
     * Determines if a system is of type Windows.
     *
     * @return bool
     */
    public function isWindows(): bool
    {
        return $this->family() === 'windows';
    }

    /**
     * Determines if a system is of type BSD.
     *
     * @return bool
     */
    public function isBSD(): bool
    {
        return $this->family() === 'bsd';
    }

    /**
     * Determines if a system is of type Darwin.
     *
     * @return bool
     */
    public function isDarwin(): bool
    {
        return $this->family() === 'darwin';
    }

    /**
     * Determines if a system is of type Solaris.
     *
     * @return bool
     */
    public function isSolaris(): bool
    {
        return $this->family() === 'solaris';
    }

    /**
     * Determines if a system is of type Linux.
     *
     * @return bool
     */
    public function isLinux(): bool
    {
        return $this->family() === 'linux';
    }

    /**
     * Determines if the current operating system is unknown.
     *
     * @return bool
     */
    public function isUnknown(): bool
    {
        return $this->family() === 'unknown';
    }

    /**
     * Determines the operating system family.
     *
     * @return bool
     */
    public function family(): string
    {
        return Str::lower(PHP_OS_FAMILY);
    }
}
