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

namespace Helldar\Support\Callbacks;

class Empties
{
    public function notEmpty(): callable
    {
        return static function ($value) {
            return ! empty($value);
        };
    }

    public function notEmptyBoth(): callable
    {
        return static function ($value, $key) {
            return ! empty($value) && ! empty($key);
        };
    }
}
