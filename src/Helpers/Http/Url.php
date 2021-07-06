<?php

namespace Helldar\Support\Helpers\Http;

use Helldar\Support\Exceptions\NotValidUrlException;
use Helldar\Support\Facades\Http\Builder as UrlBuilder;
use Throwable;

class Url
{
    /**
     * Parsing URL into components.
     *
     * @param  \Psr\Http\Message\UriInterface|string|null  $url
     *
     * @return \Helldar\Support\Helpers\Http\Builder
     */
    public function parse($url): Builder
    {
        return UrlBuilder::parse($url);
    }

    /**
     * Check if the string is a valid URL.
     *
     * @param  \Psr\Http\Message\UriInterface|string|null  $url
     *
     * @return bool
     */
    public function is($url): bool
    {
        return filter_var((string) $url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Validate if the value is a valid URL or throw an error.
     *
     * @param  \Psr\Http\Message\UriInterface|string|null  $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     */
    public function validate($url): void
    {
        if (! $this->is($url)) {
            throw new NotValidUrlException((string) $url);
        }
    }

    /**
     * Returns the URL after validation, or throws an error.
     *
     * @param  \Psr\Http\Message\UriInterface|string|null  $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return string
     */
    public function validated($url): string
    {
        $this->validate($url);

        return (string) $url;
    }

    /**
     * Check if the specified URL exists.
     *
     * @param  \Psr\Http\Message\UriInterface|string|null  $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return bool
     */
    public function exists($url): bool
    {
        $this->validate($url);

        try {
            $headers = get_headers($url);

            $key = array_search('HTTP/', $headers);

            $value = $headers[$key] ?? null;

            preg_match('/HTTP\/\d{1}\.?\d?\s[2-3]\d{2}/i', $value, $matches);

            return count($matches) > 0;
        }
        catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Check the existence of the URL and return the default value if it is missing.
     *
     * @param  \Psr\Http\Message\UriInterface|string  $url
     * @param  \Psr\Http\Message\UriInterface|string  $default
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return string|null
     */
    public function default($url, $default): string
    {
        $value = $this->exists($url) ? $url : $default;

        return $this->validated($value);
    }
}
