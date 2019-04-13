<?php

namespace Helldar\Support\Helpers;

class Http
{
    /**
     * Checks whether the string is URL address
     *
     * @param string $path
     *
     * @return bool
     */
    public static function isUrl(string $path): bool
    {
        return filter_var($path, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Checks whether a file or directory exists on URL.
     *
     * @param string $url
     *
     * @return bool
     */
    public static function exists(string $url): bool
    {
        try {
            $headers = \get_headers($url);

            return \stripos(\reset($headers), '200 OK') !== false;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * Get the domain name from the URL.
     *
     * @param string|null $url
     *
     * @return string
     */
    public static function baseUrl(string $url = null): string
    {
        if (\is_null($url)) {
            $url = $_SERVER['HTTP_HOST'];
        }

        return \parse_url($url, PHP_URL_HOST);
    }

    /**
     * Reverse function for parse_url() (http://php.net/manual/en/function.parse-url.php).
     *
     * @see https://gist.github.com/Ellrion/f51ba0d40ae1d62eeae44fd1adf7b704
     *
     * @param array $parsed_url
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
     * Retrieving the current subdomain name.
     *
     * @param string|null $url
     *
     * @return string|null
     */
    public static function getSubdomain(string $url = null): ?string
    {
        $host = explode('.', self::baseUrl($url));

        if (\sizeof($host) > 2) {
            return \reset($host);
        }

        return null;
    }
}
