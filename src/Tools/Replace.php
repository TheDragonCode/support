<?php

namespace Helldar\Support\Tools;

class Replace
{
    public function toFormat(string $value, string $format = null): string
    {
        return empty($format) || $format === '%s' ? $value : sprintf($format, $value);
    }

    public function toFormatArray(array $values, string $format = null): array
    {
        if (empty($format)) {
            return $values;
        }

        return array_map(static function ($value) use ($format) {
            return sprintf($format, $value);
        }, $values);
    }
}
