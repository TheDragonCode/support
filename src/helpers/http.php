<?php

use Helldar\Support\Facades\Http;

if (! function_exists('url_exists')) {
    /**
     * Checks whether a file or directory exists on URL.
     *
     * @param string $url
     *
     * @return bool
     */
    function url_exists($url): bool
    {
        return Http::exists($url);
    }
}

if (! function_exists('base_url')) {
    /**
     * Get the domain name from the URL.
     *
     * @param $url
     *
     * @return string
     */
    function base_url(string $url = null): string
    {
        return Http::baseUrl($url);
    }
}

if (! function_exists('subdomain_name')) {
    /**
     * Retrieving the current subdomain name.
     *
     * @param string|null $url
     *
     * @return string|null
     */
    function subdomain_name(string $url = null): ?string
    {
        return Http::subdomain($url);
    }
}
