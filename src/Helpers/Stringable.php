<?php

namespace Helldar\Support\Helpers;

use Helldar\Support\Facades\Helpers\Str as Helper;
use Stringable as StringableContract;

final class Stringable implements StringableContract
{
    protected $value;

    public function __construct(?string $value = null)
    {
        $this->value = (string) $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * Creates the current object in case of accessing the Stringable through the facade.
     *
     * @param  string|null  $value
     *
     * @return $this
     */
    public function of(?string $value): self
    {
        return new self($value);
    }

    /**
     * Replacing multiple spaces with a single space.
     *
     * @return \Helldar\Support\Helpers\Stringable
     */
    public function removeSpaces(): self
    {
        return new self(Helper::removeSpaces($this->value));
    }

    /**
     * Begin a string with a single instance of a given value.
     *
     * @param  string  $prefix
     *
     * @return \Helldar\Support\Helpers\Stringable
     */
    public function start(string $prefix): self
    {
        return new self(Helper::start($this->value, $prefix));
    }

    /**
     * Cap a string with a single instance of a given value.
     *
     * @param  string  $cap
     *
     * @return \Helldar\Support\Helpers\Stringable
     */
    public function finish(string $cap = '/'): self
    {
        return new self(Helper::finish($this->value, $cap));
    }

    /**
     * Convert the given string to lower-case.
     *
     * @return \Helldar\Support\Helpers\Stringable
     */
    public function lower(): self
    {
        return new self(Helper::lower($this->value));
    }

    /**
     * Convert the given string to upper-case.
     *
     * @return \Helldar\Support\Helpers\Stringable
     */
    public function upper(): self
    {
        return new self(Helper::upper($this->value));
    }

    /**
     * Convert a value to studly caps case.
     *
     * @return \Helldar\Support\Helpers\Stringable
     */
    public function studly(): self
    {
        return new self(Helper::studly($this->value));
    }

    /**
     * Convert a value to camel case.
     *
     * @return \Helldar\Support\Helpers\Stringable
     */
    public function camel(): self
    {
        return new self(Helper::camel($this->value));
    }

    /**
     * Convert a string to snake case.
     *
     * @param  string|null  $delimiter
     *
     * @return \Helldar\Support\Helpers\Stringable
     */
    public function snake(?string $delimiter = '_'): self
    {
        return new self(Helper::snake($this->value, $delimiter));
    }

    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param  string  $separator
     * @param  string|null  $language
     *
     * @return \Helldar\Support\Helpers\Stringable
     */
    public function slug(string $separator = '-', ?string $language = 'en'): self
    {
        return new self(Helper::slug($this->value, $separator, $language));
    }

    /**
     * Convert the given string to title case.
     *
     * @return \Helldar\Support\Helpers\Stringable
     */
    public function title(): self
    {
        return new self(Helper::title($this->value));
    }

    /**
     * Returns the portion of string specified by the start and length parameters.
     *
     * @param  int  $start
     * @param  int|null  $length
     *
     * @return \Helldar\Support\Helpers\Stringable
     */
    public function substr(int $start, int $length = null): self
    {
        return new self(Helper::substr($this->value, $start, $length));
    }

    /**
     * Replace all occurrences of the search string with the replacement string.
     *
     * @param  array  $values
     * @param  string|null  $key_format
     *
     * @return \Helldar\Support\Helpers\Stringable
     */
    public function replace(array $values, string $key_format = null): self
    {
        return new self(Helper::replace($this->value, $values, $key_format));
    }

    /**
     * Get the portion of a string before the first occurrence of a given value.
     *
     * @param  string  $search
     *
     * @return \Helldar\Support\Helpers\Stringable
     */
    public function before(string $search): self
    {
        return new self(Helper::before($this->value, $search));
    }

    /**
     * Return the remainder of a string after the first occurrence of a given value.
     *
     * @param  string  $search
     *
     * @return \Helldar\Support\Helpers\Stringable
     */
    public function after(string $search): self
    {
        return new self(Helper::after($this->value, $search));
    }

    /**
     * Get the string matching the given pattern.
     *
     * @param  string  $pattern
     *
     * @return \Helldar\Support\Helpers\Stringable
     */
    public function match(string $pattern): self
    {
        return new self(Helper::match($this->value, $pattern));
    }

    /**
     * Transliterate a UTF-8 value to ASCII.
     *
     * @param  string|null  $language
     *
     * @return \Helldar\Support\Helpers\Stringable
     */
    public function ascii(?string $language = 'en'): self
    {
        return new self(Helper::ascii($this->value, $language));
    }
}
