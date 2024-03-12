<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2024 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Application\Version;

use DragonCode\Support\Application\Version;
use DragonCode\Support\Facades\Application\Version as VersionFacade;
use Tests\TestCase;

abstract class Base extends TestCase
{
    protected string $version = '4.5.6';

    protected function version(): Version
    {
        return VersionFacade::of($this->version);
    }
}
