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

namespace Helldar\Support\Facades\Http;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Helpers\Http\Url as Helper;

/**
 * @method static \Helldar\Support\Helpers\Http\Builder parse(string|\Helldar\Contracts\Http\Builder|null $url)
 * @method static bool exists(string|\Helldar\Contracts\Http\Builder|null $url)
 * @method static bool is(string|\Helldar\Contracts\Http\Builder|null $url)
 * @method static \Helldar\Support\Helpers\Http\Builder|\Helldar\Contracts\Http\Builder|string validated(string|\Helldar\Contracts\Http\Builder|null $url)
 * @method static string|null default(string|\Helldar\Contracts\Http\Builder|null $url, string|\Helldar\Contracts\Http\Builder|null $default)
 * @method static void validate(string|\Helldar\Contracts\Http\Builder|null $url)
 */
class Url extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
