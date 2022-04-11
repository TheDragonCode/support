<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Http;

use DragonCode\Contracts\Http\Builder as BuilderContract;
use DragonCode\Support\Exceptions\NotValidUrlException;
use DragonCode\Support\Facades\Http\Builder as UrlBuilder;
use Psr\Http\Message\UriInterface;
use Throwable;

class Url
{
    /**
     * Parsing URL into components.
     *
     * @param BuilderContract|string|null $url
     *
     * @return \DragonCode\Support\Http\Builder
     */
    public function parse(UriInterface|string|null $url): Builder
    {
        return UrlBuilder::parse($url);
    }

    /**
     * Check if the string is a valid URL.
     *
     * @param BuilderContract|string|null $url
     *
     * @return bool
     */
    public function is(mixed $url): bool
    {
        return filter_var((string) $url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Validate if the value is a valid URL or throw an error.
     *
     * @param BuilderContract|string|null $url
     *
     * @throws \DragonCode\Support\Exceptions\NotValidUrlException
     */
    public function validate(mixed $url): void
    {
        if (! $this->is($url)) {
            throw new NotValidUrlException((string) $url);
        }
    }

    /**
     * Returns the URL after validation, or throws an error.
     *
     * @param BuilderContract|string|null $url
     *
     * @throws \DragonCode\Support\Exceptions\NotValidUrlException
     *
     * @return BuilderContract|\DragonCode\Support\Http\Builder|string
     */
    public function validated(mixed $url): mixed
    {
        $this->validate($url);

        return $url;
    }

    /**
     * Check if the specified URL exists.
     *
     * @param BuilderContract|string|null $url
     *
     * @throws \DragonCode\Support\Exceptions\NotValidUrlException
     *
     * @return bool
     */
    public function exists(UriInterface|string|null $url): bool
    {
        $this->validate($url);

        try {
            $headers = get_headers($url);

            $key = array_search('HTTP/', $headers);

            $value = $headers[$key] ?? null;

            preg_match('/HTTP\/\d{1}\.?\d?\s[2-3]\d{2}/i', $value, $matches);

            return count($matches) > 0;
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Check the existence of the URL and return the default value if it is missing.
     *
     * @param BuilderContract|string $url
     * @param BuilderContract|string $default
     *
     * @throws \DragonCode\Support\Exceptions\NotValidUrlException
     *
     * @return string|null
     */
    public function default(UriInterface|string $url, UriInterface|string $default): string
    {
        $value = $this->exists($url) ? $url : $default;

        return $this->validated($value);
    }
}
