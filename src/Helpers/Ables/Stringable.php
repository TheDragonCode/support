<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2023 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Helpers\Ables;

use DragonCode\Contracts\Support\Stringable as Contract;
use DragonCode\Support\Concerns\Dumpable;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Facades\Instances\Call;
use JetBrains\PhpStorm\Pure;

class Stringable implements Contract
{
    use Dumpable;

    public function __construct(
        protected ?string $value = null
    ) {
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return (string) $this->value;
    }

    public function of(?string $value = null): self
    {
        $this->value = (string) $value;

        return $this;
    }

    /**
     * Performing an action on a condition.
     *
     * @param mixed $condition
     * @param mixed $callback
     * @param mixed $default
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function when(mixed $condition, mixed $callback, mixed $default = null): self
    {
        if (Call::value($condition, $this)) {
            $value = Call::value($callback, $this);

            return new self($value);
        }

        return ! is_null($default) ? $this->when(true, $default) : $this;
    }

    /**
     * Split a string by a string.
     *
     * @param string $separator
     * @param string|null $map_into
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    #[Pure]
    public function explode(string $separator, ?string $map_into = null): Arrayable
    {
        $array = Arr::of(explode($separator, $this->toString()));

        return $map_into ? $array->mapInto($map_into) : $array;
    }

    /**
     * Escape HTML special characters in a string.
     *
     * @param bool $double
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function e(bool $double = true): self
    {
        return new self(Str::e($this->toString(), $double));
    }

    /**
     * Convert special HTML entities back to characters.
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function de(): self
    {
        return new self(Str::de($this->toString()));
    }

    /**
     * Replacing multiple spaces with a single space.
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function squish(): self
    {
        return new self(Str::squish($this->toString()));
    }

    /**
     * Begin a string with a single instance of a given value.
     *
     * @param string $prefix
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function start(string $prefix): self
    {
        return new self(Str::start($this->toString(), $prefix));
    }

    /**
     * End a string with a single instance of a given value.
     *
     * @param string $suffix
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function end(string $suffix): self
    {
        return new self(Str::end($this->toString(), $suffix));
    }

    /**
     * Adds a substring to the end of a string.
     *
     * @param mixed $suffix
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function append(mixed $suffix): self
    {
        return new self(Str::append($this->toString(), $suffix));
    }

    /**
     * Adds a substring to the start of a string.
     *
     * @param mixed $prefix
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function prepend(mixed $prefix): self
    {
        return new self(Str::prepend($this->toString(), $prefix));
    }

    /**
     * Cap a string with a single instance of a given value.
     *
     * @param string $cap
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function finish(string $cap = '/'): self
    {
        return new self(Str::finish($this->toString(), $cap));
    }

    /**
     * Convert the given string to lower-case.
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function lower(): self
    {
        return new self(Str::lower($this->toString()));
    }

    /**
     * Convert the given string to upper-case.
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function upper(): self
    {
        return new self(Str::upper($this->toString()));
    }

    /**
     * Convert a value to studly caps case.
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function studly(): self
    {
        return new self(Str::studly($this->toString()));
    }

    /**
     * Convert a value to camel case.
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function camel(): self
    {
        return new self(Str::camel($this->toString()));
    }

    /**
     * Convert a string to snake case.
     *
     * @param string|null $delimiter
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function snake(?string $delimiter = '_'): self
    {
        return new self(Str::snake($this->toString(), $delimiter));
    }

    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param string $separator
     * @param string|null $language
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function slug(string $separator = '-', ?string $language = 'en'): self
    {
        return new self(Str::slug($this->toString(), $separator, $language));
    }

    /**
     * Convert the given string to title case.
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function title(): self
    {
        return new self(Str::title($this->toString()));
    }

    /**
     * Returns the portion of string specified by the start and length parameters.
     *
     * @param int $start
     * @param int|null $length
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function substr(int $start, ?int $length = null): self
    {
        return new self(Str::substr($this->toString(), $start, $length));
    }

    /**
     * Replace all occurrences of the search string with the replacement string by format.
     *
     * @param array $values
     * @param string|null $key_format
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function replaceFormat(array $values, ?string $key_format = null): self
    {
        return new self(Str::replaceFormat($this->toString(), $values, $key_format));
    }

    /**
     * Replace all occurrences of the search string with the replacement string.
     *
     * @param array|string|string[]|int|float $search
     * @param array|string|string[]|int|float $replace
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function replace(mixed $search, mixed $replace): self
    {
        return new self(Str::replace($this->toString(), $search, $replace));
    }

    /**
     * Get the portion of a string before the first occurrence of a given value.
     *
     * @param string $search
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function before(string $search): self
    {
        return new self(Str::before($this->toString(), $search));
    }

    /**
     * Return the remainder of a string after the first occurrence of a given value.
     *
     * @param string $search
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function after(string $search): self
    {
        return new self(Str::after($this->toString(), $search));
    }

    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param int $length
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function random(int $length = 16): self
    {
        return new self(Str::random($length));
    }

    /**
     * Get the string matching the given pattern.
     *
     * @param string $pattern
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function match(string $pattern): self
    {
        return new self(Str::match($this->toString(), $pattern));
    }

    /**
     * Get the all string matching the given pattern.
     *
     * @param string $pattern
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function matchAll(string $pattern): Arrayable
    {
        return Arr::of(Str::matchAll($this->toString(), $pattern));
    }

    /**
     * Determine if a given string contains a given substring by regex.
     *
     * @param array|string $pattern
     *
     * @return bool
     */
    public function matchContains(array|string $pattern): bool
    {
        return Str::matchContains($this->toString(), $pattern);
    }

    /**
     * Replace a given value in the string.
     *
     * @param string $pattern
     * @param string $replacement
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function pregReplace(string $pattern, string $replacement): self
    {
        return new self(Str::pregReplace($this->toString(), $pattern, $replacement));
    }

    /**
     * Transliterate a UTF-8 value to ASCII.
     *
     * @param string|null $language
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function ascii(?string $language = 'en'): self
    {
        return new self(Str::ascii($this->toString(), $language));
    }

    /**
     * Using a call-back function to process a value.
     *
     * @param callable $callback
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function map(callable $callback): self
    {
        return new self(Str::map($this->toString(), $callback));
    }

    /**
     * Get the portion of a string between two given values.
     *
     * @param mixed $from
     * @param mixed $to
     * @param bool $trim
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    #[Pure]
    public function between(mixed $from, mixed $to, bool $trim = true): self
    {
        return new self(Str::between($this->toString(), $from, $to, $trim));
    }

    /**
     * Strip whitespace (or other characters) from the beginning and end of a string.
     *
     * @param string $characters
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function trim(string $characters = " \t\n\r\0\x0B"): self
    {
        return new self(Str::trim($this->toString(), $characters));
    }

    /**
     * Strip whitespace (or other characters) from the beginning of a string.
     *
     * @param string $characters
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function ltrim(string $characters = " \t\n\r\0\x0B"): self
    {
        return new self(Str::ltrim($this->toString(), $characters));
    }

    /**
     * Strip whitespace (or other characters) from the end of a string.
     *
     * @param string $characters
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function rtrim(string $characters = " \t\n\r\0\x0B"): self
    {
        return new self(Str::rtrim($this->toString(), $characters));
    }

    /**
     * Determine if a given string matches a given pattern.
     *
     * @see https://github.com/illuminate/support/blob/master/Str.php
     *
     * @param array|string $pattern
     *
     * @return bool
     */
    public function is(array|string $pattern): bool
    {
        return Str::is($pattern, $this->toString());
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param mixed $needles
     *
     * @return bool
     */
    public function startsWith(mixed $needles): bool
    {
        return Str::startsWith($this->toString(), $needles);
    }

    /**
     * Determine if a given string ends with a given substring.
     *
     * @param mixed $needles
     *
     * @return bool
     */
    public function endsWith(mixed $needles): bool
    {
        return Str::endsWith($this->toString(), $needles);
    }

    /**
     * Return the length of the given string.
     *
     * @see https://github.com/illuminate/support/blob/master/Str.php
     *
     * @param string|null $encoding
     *
     * @return int
     */
    public function length(?string $encoding = null): int
    {
        return Str::length($this->toString(), $encoding);
    }

    /**
     * Count the number of substring occurrences.
     *
     * @param string $needle
     * @param int $offset
     *
     * @return int
     */
    public function count(string $needle, int $offset = 0): int
    {
        return Str::count($this->value, $needle, $offset);
    }

    /**
     * Determine if a given string contains a given substring.
     *
     * @param mixed $needles
     *
     * @return bool
     */
    public function contains(mixed $needles): bool
    {
        return Str::contains($this->toString(), $needles);
    }

    /**
     * Determines if the value is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return Str::isEmpty($this->value);
    }

    /**
     * Determines if the value is doesn't empty.
     *
     * @return bool
     */
    public function doesntEmpty(): bool
    {
        return Str::doesntEmpty($this->value);
    }
}
