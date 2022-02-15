<?php
/*
 * This file is part of the "dragon-code/support" project.
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
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Tools;

class Replace
{
    public function toFormat(string $value, ?string $format = null): string
    {
        return empty($format) || $format === '%s' ? $value : sprintf($format, $value);
    }

    public function toFormatArray(array $values, ?string $format = null): array
    {
        if (empty($format)) {
            return $values;
        }

        return array_map(static function ($value) use ($format) {
            return sprintf($format, $value);
        }, $values);
    }
}
