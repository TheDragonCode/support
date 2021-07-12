<?php
/******************************************************************************
 * This file is part of the "andrey-helldar/support" project.                 *
 *                                                                            *
 * @author Andrey Helldar <helldar@ai-rus.com>                                *
 *                                                                            *
 * @copyright 2021 Andrey Helldar                                             *
 *                                                                            *
 * @license MIT                                                               *
 *                                                                            *
 * @see https://github.com/andrey-helldar/support                             *
 *                                                                            *
 * For the full copyright and license information, please view the LICENSE    *
 * file that was distributed with this source code.                           *
 ******************************************************************************/

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Helpers\Boolean as Helper;

/**
 * @method static bool isFalse($value)
 * @method static bool isTrue($value)
 * @method static bool to($value)
 * @method static bool|null parse($value)
 * @method static string convertToString(bool $value)
 */
class Boolean extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
