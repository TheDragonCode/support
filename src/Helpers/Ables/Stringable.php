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

namespace DragonCode\Support\Helpers\Ables;

use DragonCode\Contracts\Support\Stringable as Contract;
use DragonCode\Support\Facades\Helpers\Str;

class Stringable implements Contract
{
    protected $value;

    public function __construct(?string $value = null)
    {
        $this->value = (string) $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }

    public function of($value = [])
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Split a string by a string.
     *
     * @param string $separator
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function explode(string $separator): Arrayable
    {
        return new Arrayable(
            explode($separator, $this->value)
        );
    }

    /**
     * Escape HTML special characters in a string.
     *
     * @param bool $double
     *
     * @return $this
     */
    public function e(bool $double = true): self
    {
        return new self(Str::e($this->value, $double));
    }

    /**
     * Convert special HTML entities back to characters.
     *
     * @return string|null
     */
    public function de(): ?string
    {
        return new self(Str::de($this->value));
    }

    /**
     * Replacing multiple spaces with a single space.
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function removeSpaces(): self
    {
        return new self(Str::removeSpaces($this->value));
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
        return new self(Str::start($this->value, $prefix));
    }

    /**
     * End a string with a single instance of a given value.
     *
     * @param string $suffix
     *
     * @return $this
     */
    public function end(string $suffix): self
    {
        return new self(Str::end($this->value, $suffix));
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
        return new self(Str::finish($this->value, $cap));
    }

    /**
     * Convert the given string to lower-case.
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function lower(): self
    {
        return new self(Str::lower($this->value));
    }

    /**
     * Convert the given string to upper-case.
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function upper(): self
    {
        return new self(Str::upper($this->value));
    }

    /**
     * Convert a value to studly caps case.
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function studly(): self
    {
        return new self(Str::studly($this->value));
    }

    /**
     * Convert a value to camel case.
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function camel(): self
    {
        return new self(Str::camel($this->value));
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
        return new self(Str::snake($this->value, $delimiter));
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
        return new self(Str::slug($this->value, $separator, $language));
    }

    /**
     * Convert the given string to title case.
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function title(): self
    {
        return new self(Str::title($this->value));
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
        return new self(Str::substr($this->value, $start, $length));
    }

    /**
     * Replace all occurrences of the search string with the replacement string.
     *
     * @param array $values
     * @param string|null $key_format
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    public function replace(array $values, ?string $key_format = null): self
    {
        return new self(Str::replace($this->value, $values, $key_format));
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
        return new self(Str::before($this->value, $search));
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
        return new self(Str::after($this->value, $search));
    }

    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param int $length
     *
     * @return $this
     */
    public function random(int $length = 16): self
    {
        return new self(Str::random($length));
    }

    /**
     * Strip whitespace (or other characters) from the beginning and end of a string.
     *
     * @see  https://php.net/manual/en/function.trim.php
     *
     * @param string $characters
     *
     * @return $this
     */
    public function trim(string $characters = " \t\n\r\0\x0B"): self
    {
        return new self(trim($this->value, $characters));
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
        return new self(Str::match($this->value, $pattern));
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
        return new self(Str::pregReplace($this->value, $pattern, $replacement));
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
        return new self(Str::ascii($this->value, $language));
    }

    /**
     * Using a call-back function to process a value.
     *
     * @param callable $callback
     *
     * @return $this
     */
    public function map(callable $callback): self
    {
        return new self(Str::map($this->value, $callback));
    }

    /**
     * Outputs the contents of a variable without terminating the application.
     *
     * @return $this
     */
    public function dump(): self
    {
        dump($this->value);

        return $this;
    }

    /**
     * Outputs the contents of a variable, terminating the application.
     */
    public function dd(): void
    {
        dd($this->value);
    }
}
