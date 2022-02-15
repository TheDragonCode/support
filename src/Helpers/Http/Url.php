<?php
/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Helpers\Http;

use DragonCode\Support\Exceptions\NotValidUrlException;
use DragonCode\Support\Facades\Http\Builder as UrlBuilder;
use Throwable;

class Url
{
    /**
     * Parsing URL into components.
     *
     * @param \DragonCode\Contracts\Http\Builder|string|null $url
     *
     * @return \DragonCode\Support\Helpers\Http\Builder
     */
    public function parse($url): Builder
    {
        return UrlBuilder::parse($url);
    }

    /**
     * Check if the string is a valid URL.
     *
     * @param \DragonCode\Contracts\Http\Builder|string|null $url
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
     * @param \DragonCode\Contracts\Http\Builder|string|null $url
     *
     * @throws \DragonCode\Support\Exceptions\NotValidUrlException
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
     * @param \DragonCode\Contracts\Http\Builder|string|null $url
     *
     * @throws \DragonCode\Support\Exceptions\NotValidUrlException
     *
     * @return \DragonCode\Contracts\Http\Builder|\DragonCode\Support\Helpers\Http\Builder|string
     */
    public function validated($url)
    {
        $this->validate($url);

        return $url;
    }

    /**
     * Check if the specified URL exists.
     *
     * @param \DragonCode\Contracts\Http\Builder|string|null $url
     *
     * @throws \DragonCode\Support\Exceptions\NotValidUrlException
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
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Check the existence of the URL and return the default value if it is missing.
     *
     * @param \DragonCode\Contracts\Http\Builder|string $url
     * @param \DragonCode\Contracts\Http\Builder|string $default
     *
     * @throws \DragonCode\Support\Exceptions\NotValidUrlException
     *
     * @return string|null
     */
    public function default($url, $default): string
    {
        $value = $this->exists($url) ? $url : $default;

        return $this->validated($value);
    }
}
