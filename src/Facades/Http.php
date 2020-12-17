<?php

namespace Helldar\Support\Facades;

use Exception;
use Helldar\Support\Exceptions\NotValidUrlException;

class Http
{
    /**
     * Checks whether the string is URL address.
     *
     * @param  string|null  $path
     *
     * @return bool
     */
    public static function isUrl(string $path = null): bool
    {
        return filter_var($path, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Checks whether a file or directory exists on URL.
     *
     * @param  string  $url
     *
     * @return bool
     */
    public static function exists(string $url): bool
    {
        try {
            $headers = get_headers($url);

            $key   = array_search('HTTP/', $headers);
            $value = $headers[$key] ?? null;

            return stripos($value, '200 OK') !== false;
        }
        catch (Exception $exception) {
            return false;
        }
    }

    /**
     * Get the domain name from the URL.
     *
     * @param  string|null  $url
     * @param  string|null  $default
     *
     * @throws NotValidUrlException
     *
     * @return string
     */
    public static function baseUrl(string $url = null, string $default = null): string
    {
        if (is_null($url)) {
            return $default ?: $_SERVER['HTTP_HOST'] ?? 'localhost';
        }

        if (! static::isUrl($url)) {
            throw new NotValidUrlException($url);
        }

        return parse_url($url, PHP_URL_HOST);
    }

    /**
     * Reverse function for parse_url() (http://php.net/manual/en/function.parse-url.php).
     *
     * @see https://gist.github.com/Ellrion/f51ba0d40ae1d62eeae44fd1adf7b704
     *
     * @param  array  $parsed_url
     *
     * @return string
     */
    public static function buildUrl(array $parsed_url)
    {
        $scheme = isset($parsed_url['scheme']) ? ($parsed_url['scheme'] . '://') : '';

        $host = $parsed_url['host'] ?? '';
        $port = isset($parsed_url['port']) ? (':' . $parsed_url['port']) : '';

        $user = $parsed_url['user'] ?? '';

        $pass = isset($parsed_url['pass']) ? (':' . $parsed_url['pass']) : '';
        $pass = ($user || $pass) ? ($pass . '@') : '';

        $path = $parsed_url['path'] ?? '';
        $path = $path ? ('/' . ltrim($path, '/')) : '';

        $query    = isset($parsed_url['query']) ? ('?' . $parsed_url['query']) : '';
        $fragment = isset($parsed_url['fragment']) ? ('#' . $parsed_url['fragment']) : '';

        return implode('', [$scheme, $user, $pass, $host, $port, $path, $query, $fragment]);
    }

    /**
     * Retrieving the current domain schema.
     *
     * @param  string|null  $url
     *
     * @return string|null
     */
    public static function scheme(string $url = null): ?string
    {
        return static::isUrl($url)
            ? parse_url($url, PHP_URL_SCHEME)
            : null;
    }

    /**
     * Retrieving the current domain name.
     *
     * @param  string|null  $url
     *
     * @return string|null
     */
    public static function domain(string $url = null): ?string
    {
        return static::isUrl($url)
            ? parse_url($url, PHP_URL_HOST)
            : null;
    }

    /**
     * Retrieving the current domain name with schema.
     *
     * @param  string|null  $url
     *
     * @return string|null
     */
    public static function host(string $url = null): ?string
    {
        if (static::isUrl($url)) {
            return static::buildUrl([
                'scheme' => static::scheme($url),
                'host'   => static::domain($url),
            ]);
        }

        return null;
    }

    /**
     * Retrieving the current subdomain name.
     *
     * @param  string|null  $url
     * @param  string|null  $default
     *
     * @throws NotValidUrlException
     *
     * @return string|null
     */
    public static function subdomain(string $url = null, string $default = null): ?string
    {
        $host = explode('.', static::baseUrl($url, $default));

        if (count($host) > 2) {
            return reset($host);
        }

        return null;
    }

    /**
     * Check the existence of the file and return the default value if it is missing.
     *
     * @param  string  $url
     * @param  string|null  $default
     *
     * @return string
     */
    public static function imageOrDefault(string $url, string $default = null): ?string
    {
        return static::isUrl($url)
            ? (static::exists($url) ? $url : $default)
            : (file_exists($url) ? $url : $default);
    }
}
