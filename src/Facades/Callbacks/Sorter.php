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

namespace DragonCode\Support\Facades\Callbacks;

use DragonCode\Support\Callbacks\Sorter as Callback;
use DragonCode\Support\Facades\Facade;

/**
 * @method static array specialChars()
 * @method static callable default()
 */
class Sorter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Callback::class;
    }
}
