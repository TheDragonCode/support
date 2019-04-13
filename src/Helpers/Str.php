<?php

namespace Helldar\Support\Helpers;

class Str
{
    /**
     * Escape HTML special characters in a string.
     *
     * @param string $value
     * @param bool $double_encode
     *
     * @return string
     */
    public static function e(string $value, bool $double_encode = true): string
    {
        return \htmlspecialchars($value, ENT_QUOTES, 'UTF-8', $double_encode);
    }

    /**
     * Convert special HTML entities back to characters.
     *
     * @param string $value
     *
     * @return string
     */
    public function de(string $value)
    {
        return \htmlspecialchars_decode($value, ENT_QUOTES);
    }

    /**
     * Replacing multiple spaces with a single space.
     *
     * @param string $value
     *
     * @return string|null
     */
    public function replaceSpaces(string $value): ?string
    {
        return \preg_replace('!\s+!', ' ', $value);
    }

    /**
     * The str_choice function translates the given language line with inflection.
     *
     * @param string $value
     * @param array $choice
     * @param string $additional
     *
     * @return string
     */
    public function choice(string $value, array $choice = [], string $additional = '')
    {
        $result = $choice[0] ?? '';
        $num    = (int) $value;
        $mod    = $num % 10;

        if ($mod == 0 || ($mod >= 5 && $mod <= 9) || ($num % 100 >= 11 && $num % 100 <= 20)) {
            $result = $choice[2] ?? '';
        } elseif ($mod >= 2 && $mod <= 4) {
            $result = $choice[1] ?? '';
        }

        if (empty(\trim($additional))) {
            return \trim($result);
        }

        return \implode(' ', [\trim($result), \trim($additional)]);
    }
}
