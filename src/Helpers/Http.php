<?php

namespace Helldar\Support\Helpers;

use Exception;
use Helldar\Support\Exceptions\NotValidUrlException;
use Helldar\Support\Helpers\Filesystem\File;

final class Http
{
    /**
     * Checks whether the string is URL address.
     *
     * @param  string|null  $url
     *
     * @return bool
     */
    public function isUrl(string $url = null): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    public function validateUrl(string $url = null): void
    {
        if (! $this->isUrl($url)) {
            throw new NotValidUrlException($url);
        }
    }

    /**
     * Checks whether a URL exists.
     *
     * @param  string  $url
     *
     * @return bool
     */
    public function exists(string $url): bool
    {
        try {
            $headers = get_headers($url);

            $key   = array_search('HTTP/', $headers);
            $value = $headers[$key] ?? null;

            preg_match('[2-3]{1}\d{2}\sOK', $value, $matches);

            return count($matches) > 0;
        }
        catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get the domain name from the URL.
     *
     * @param  string|null  $url
     * @param  string|null  $default
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return string
     */
    public function domain(string $url = null, string $default = null): string
    {
        if (is_null($url)) {
            return $default ?: $_SERVER['HTTP_HOST'] ?? 'localhost';
        }

        $this->validateUrl($url);

        return HttpBuilder::parse($url)->getHost();
    }

    /**
     * Retrieving the current subdomain name.
     *
     * @param  string|null  $url
     * @param  string|null  $default
     *
     * @return string|null
     */
    public function subdomain(string $url = null, string $default = null): ?string
    {
        $host = explode('.', HttpBuilder::parse($url)->getHost());

        return count($host) > 2 ? reset($host) : $default;
    }

    public function host(string $url = null): ?string
    {
        if (! $this->isUrl($url)) {
            return null;
        }

        return HttpBuilder::make()
            ->parse($url, PHP_URL_SCHEME)
            ->parse($url, PHP_URL_HOST)
            ->compile();
    }

    public function scheme(string $url): ?string
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
     * @return string|null
     */
    public function image(string $url, string $default = null): ?string
    {
        return $this->isUrl($url)
            ? ($this->exists($url) ? $url : $default)
            : (File::exists($url) ? $url : $default);
    }
}
