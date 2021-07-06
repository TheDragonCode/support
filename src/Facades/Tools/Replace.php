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

namespace Helldar\Support\Facades\Tools;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Tools\Replace as Tool;

/**
 * @method static string toFormat(string $value, string $format = null)
 * @method static string toFormatArray(array $values, string $format = null)
 */
class Replace extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Tool::class;
    }
}
