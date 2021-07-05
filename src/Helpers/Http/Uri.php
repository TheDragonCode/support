<?php

namespace Helldar\Support\Helpers\Http;

use Exception;
use Helldar\Support\Exceptions\NotValidUrlException;
use Helldar\Support\Facades\Helpers\Filesystem\File as FileHelper;
use Helldar\Support\Facades\Helpers\Http\Builder as BuilderHelper;
use Psr\Http\Message\UriInterface;

class Uri
{
    /**
     * Check if the string is a valid URL.
     *
     * @param  UriInterface|string|null  $url
     *
     * @return bool
     */
    public function isUrl($url): bool
    {
        return filter_var((string) $url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Validate if the value is a valid URL or throw an error.
     *
     * @param  UriInterface|string|null  $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     */
    public function validateUrl($url): void
    {
        if (! $this->isUrl($url)) {
            throw new NotValidUrlException($url);
        }
    }

    /**
     * Returns the URL after validation, or throws an error.
     *
     * @param  UriInterface|string|null  $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return string
     */
    public function validatedUrl($url): string
    {
        $this->validateUrl($url);

        return $url;
    }

    /**
     * Check if the specified URL exists.
     *
     * @param  UriInterface|string|null  $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return bool
     */
    public function exists($url): bool
    {
        $this->validateUrl($url);

        try {
            $headers = get_headers((string) $url);

            $key   = array_search('HTTP/', $headers);
            $value = $headers[$key] ?? null;

            preg_match('/HTTP\/\d{1}\.?\d?\s[2-3]\d{2}/i', $value, $matches);

            return count($matches) > 0;
        }
        catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get the domain name from the URL.
     *
     * @param  UriInterface|string|null  $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return string
     */
    public function domain($url): string
    {
        $this->validateUrl($url);

        return BuilderHelper::parse($url)->getHost();
    }

    /**
     * Get the subdomain name from the URL.
     *
     * @param  UriInterface|string|null  $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return string|null
     */
    public function subdomain($url): ?string
    {
        $this->validateUrl($url);

        $host = explode('.', BuilderHelper::parse($url)->getHost());

        return count($host) > 2 ? reset($host) : null;
    }

    /**
     * Get the scheme and host from the URL.
     *
     * @param  UriInterface|string|null  $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return string
     */
    public function host($url): string
    {
        $this->validateUrl($url);

        return BuilderHelper::same()
            ->parse($url, PHP_URL_SCHEME)
            ->parse($url, PHP_URL_HOST)
            ->compile();
    }

    /**
     * Get the scheme name from the URL.
     *
     * @param  UriInterface|string|null  $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return string
     */
    public function scheme($url): string
    {
        $this->validateUrl($url);

        return BuilderHelper::parse($url)->getScheme();
    }

    /**
     * Check the existence of the file and return the default value if it is missing.
     *
     * @param  UriInterface|string  $url
     * @param  UriInterface|string|null  $default
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return string|null
     */
    public function image($url, string $default = null): ?string
    {
        return $this->isUrl($url)
            ? ($this->exists($url) ? (string) $url : (string) $default)
            : (FileHelper::exists($url) ? (string) $url : (string) $default);
    }
}
