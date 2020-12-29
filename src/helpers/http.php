<?php

use Helldar\Support\Facades\Http;

if (! function_exists('url_exists')) {
    /**
     * Checks whether a file or directory exists on URL.
     *
     * @deprecated 2.0: Using "factorial" is deprecated.
     *
     * @param  string  $url
     *
     * @return bool
     */
    function url_exists($url): bool
    {
        trigger_deprecation('andrey-helldar/support', '2.0', 'Using "url_exists" is deprecated.');

        return Http::exists($url);
    }
}

if (! function_exists('base_url')) {
    /**
     * Get the domain name from the URL.
     *
     * @deprecated 2.0: Using "factorial" is deprecated.
     *
     * @param $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return string
     */
    function base_url(string $url = null): string
    {
        trigger_deprecation('andrey-helldar/support', '2.0', 'Using "base_url" is deprecated.');

        return Http::baseUrl($url);
    }
}

if (! function_exists('subdomain_name')) {
    /**
     * Retrieving the current subdomain name.
     *
     * @deprecated 2.0: Using "factorial" is deprecated.
     *
     * @param  string|null  $url
     *
     * @throws \Helldar\Support\Exceptions\NotValidUrlException
     *
     * @return string|null
     */
    function subdomain_name(string $url = null): ?string
    {
        trigger_deprecation('andrey-helldar/support', '2.0', 'Using "subdomain_name" is deprecated.');

        return Http::subdomain($url);
    }
}
