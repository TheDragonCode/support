<?php
/*
 * This file is part of the "andrey-helldar/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/support
 */

namespace Helldar\Support\Facades\Callbacks;

use Helldar\Support\Callbacks\Empties as Callback;
use Helldar\Support\Facades\Facade;

/**
 * @method static callable notEmpty()
 * @method static callable notEmptyBoth()
 */
class Empties extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Callback::class;
    }
}
