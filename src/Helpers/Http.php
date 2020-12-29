<?php

namespace Helldar\Support\Helpers;

use Exception;
use Helldar\Support\Exceptions\NotValidUrlException;
use Helldar\Support\Facades\Helpers\Filesystem\File;
use Helldar\Support\Facades\Helpers\HttpBuilder;

final class Http
{
    /**
     * Check if the string is a valid URL.
     *
     * @param  string|null  $url
     *
     * @return bool
     */
    public function isUrl(?string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Validate if the value is a valid URL or throw an error.
     *
     * @param  string|null  $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     */
    public function validateUrl(?string $url): void
    {
        if (! $this->isUrl($url)) {
            throw new NotValidUrlException($url);
        }
    }

    /**
     * Check if the specified URL exists.
     *
     * @param  string|null  $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return bool
     */
    public function exists(?string $url): bool
    {
        $this->validateUrl($url);

        try {
            $headers = get_headers($url);

            $key   = array_search('HTTP/', $headers);
            $value = $headers[$key] ?? null;

            preg_match('/HTTP\/\d{1}\.?\d?\s[2-3]\d{2}/i', $value, $matches);

            return count($matches) > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get the domain name from the URL.
     *
     * @param  string|null  $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return string
     */
    public function domain(?string $url): string
    {
        $this->validateUrl($url);

        return HttpBuilder::parse($url)->getHost();
    }

    /**
     * Get the subdomain name from the URL.
     *
     * @param  string|null  $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return string|null
     */
    public function subdomain(?string $url): ?string
    {
        $this->validateUrl($url);

        $host = explode('.', HttpBuilder::parse($url)->getHost());

        return count($host) > 2 ? reset($host) : null;
    }

    /**
     * Get the scheme and host from the URL.
     *
     * @param  string|null  $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return string
     */
    public function host(?string $url): string
    {
        $this->validateUrl($url);

        return HttpBuilder::same()
            ->parse($url, PHP_URL_SCHEME)
            ->parse($url, PHP_URL_HOST)
            ->compile();
    }

    /**
     * Get the scheme name from the URL.
     *
     * @param  string|null  $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return string
     */
    public function scheme(?string $url): string
    {
        $this->validateUrl($url);

        return HttpBuilder::parse($url)->getScheme();
    }

    /**
     * Check the existence of the file and return the default value if it is missing.
     *
     * @param  string  $url
     * @param  string|null  $default
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return string|null
     */
    public function image(string $url, string $default = null): ?string
    {
        return $this->isUrl($url)
            ? ($this->exists($url) ? $url : $default)
            : (File::exists($url) ? $url : $default);
    }
}
