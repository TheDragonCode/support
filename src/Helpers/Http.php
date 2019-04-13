<?php

namespace Helldar\Support\Helpers;

class Http
{
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
     * @param string $url
     *
     * @return string
     */
    public static function baseUrl(string $url): string
    {
        return \parse_url($url, PHP_URL_HOST);
    }
}
