<?php

namespace Helldar\Support\Helpers;

class Images
{
    /**
     * Check the existence of the file and return the default value if it is missing.
     *
     * @param string $url
     * @param string|null $default
     *
     * @return string
     */
    public static function imageOrDefault(string $url, string $default = null): ?string
    {
        if (Http::isUrl($url)) {
            return Http::exists($url) ? $url : $default;
        }

        return \file_exists($url) ? $url : $default;
    }
}
