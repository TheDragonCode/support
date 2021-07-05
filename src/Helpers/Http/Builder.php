<?php

namespace Helldar\Support\Helpers\Http;

use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Http\Uri as UriHelper;
use Helldar\Support\Facades\Helpers\Str;
use Psr\Http\Message\UriInterface;

class Builder implements UriInterface
{
    protected $parsed = [];

    protected $components = [
        PHP_URL_SCHEME   => 'scheme',
        PHP_URL_HOST     => 'host',
        PHP_URL_PORT     => 'port',
        PHP_URL_USER     => 'user',
        PHP_URL_PASS     => 'pass',
        PHP_URL_QUERY    => 'query',
        PHP_URL_PATH     => 'path',
        PHP_URL_FRAGMENT => 'fragment',
    ];

    protected $casts = [
        'scheme'   => 'string',
        'host'     => 'string',
        'port'     => 'integer',
        'user'     => 'string',
        'pass'     => 'string',
        'query'    => 'array',
        'path'     => 'string',
        'fragment' => 'string',
    ];

    public function __toString()
    {
        return $this->toUrl();
    }

    /**
     * Gets the current instance of the object.
     *
     * @return $this
     */
    public function same(): self
    {
        return $this;
    }

    /**
     * Parse a URL.
     *
     * @param  string|UriInterface|null  $url
     * @param  int  $component
     *
     * @return $this
     */
    public function parse($url, int $component = -1): self
    {
        if ($component === -1) {
            UriHelper::validateUrl($url);
        }

        $index = $this->componentIndex($component);
        $key   = $this->componentKey($component);

        $index === -1 || empty($key)
            ? $this->parsed       = parse_url((string) $url)
            : $this->parsed[$key] = parse_url((string) $url, $index);

        $this->cast();

        return $this;
    }

    /**
     * Filling the builder with parsed data.
     *
     * @param  array  $parsed
     *
     * @return $this
     */
    public function raw(array $parsed): self
    {
        Arrayable::of($parsed)
            ->only(array_values($this->components))
            ->tap(function ($value, string $key) {
                $this->set($key, $value);
            });

        $this->cast();

        return $this;
    }

    public function getScheme(): ?string
    {
        return $this->get(PHP_URL_SCHEME);
    }

    public function getAuthority(): ?string
    {
        $user = $this->getUserInfo();
        $host = $this->getHost();
        $port = $this->getPort();

        if ($user || $host || $port) {
            $value = $user . '@' . $host . ':' . $port;

            return (string) Str::of($value)->trim('@:');
        }

        return null;
    }

    public function getUser(): ?string
    {
        return $this->get(PHP_URL_USER);
    }

    public function getPassword(): ?string
    {
        return $this->get(PHP_URL_PASS);
    }

    public function getUserInfo(): ?string
    {
        $user     = $this->getUser();
        $password = $this->getPassword();

        if (! empty($user) && ! empty($password)) {
            return $user . ':' . $password;
        }

        return null;
    }

    public function getHost(): ?string
    {
        return $this->get(PHP_URL_HOST);
    }

    public function getPort(): ?int
    {
        return $this->get(PHP_URL_PORT);
    }

    public function getPath(): ?string
    {
        return $this->get(PHP_URL_PATH);
    }

    public function getQuery(): ?string
    {
        return $this->get(PHP_URL_QUERY);
    }

    public function getFragment(): ?string
    {
        return $this->get(PHP_URL_FRAGMENT);
    }

    public function withScheme($scheme)
    {
        // TODO: Implement withScheme() method.
    }

    public function withUserInfo($user, $password = null)
    {
        // TODO: Implement withUserInfo() method.
    }

    public function withHost($host)
    {
        // TODO: Implement withHost() method.
    }

    public function withPort($port)
    {
        // TODO: Implement withPort() method.
    }

    public function withPath($path)
    {
        // TODO: Implement withPath() method.
    }

    public function withQuery($query)
    {
        // TODO: Implement withQuery() method.
    }

    public function withFragment($fragment)
    {
        // TODO: Implement withFragment() method.
    }

    /**
     * Compile to URL.
     *
     * @return string
     */
    public function toUrl(): string
    {
        return (string) $this;
    }

    /**
     * Returns parsed data.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->parsed;
    }

    protected function set(int $component, $value): void
    {
        Arr::set($this->parsed, $key, $value);
    }

    protected function get(int $component)
    {
        $key = $this->componentKey($component);

        return Arr::get($this->parsed, $key);
    }

    protected function cast(): void
    {
        Arrayable::of($this->casts)
            ->tap(function (string $cast, string $key) {
                $value = Arr::get($this->parsed, $key);

                switch ($cast) {
                    case 'array':
                        $value = $this->castToArray($value);
                        break;

                    case 'integer':
                        $value = $this->castToInteger($value);
                        break;

                    default:
                        $value = $this->castToEmpty($value);
                }

                $this->parsed = Arr::set($this->parsed, $key, $value);
            });
    }

    protected function castToArray($value): array
    {
        if (empty($value)) {
            return [];
        }

        if (is_array($value)) {
            return $value;
        }

        $items = [];

        foreach (explode('&', $value) as $item) {
            [$key, $value] = Str::contains($item, '=') ? explode('=', $item) : [0, $item];

            $items[$key] = $value;
        }

        return $items;
    }

    protected function castToInteger($value): ?int
    {
        return empty($value) && ! is_numeric($value) ? null : (int) $value;
    }

    protected function castToEmpty($value)
    {
        return empty($value) && ! is_numeric($value) ? null : $value;
    }

    /**
     * Gets the index of the component.
     *
     * @param  int  $component
     *
     * @return int
     */
    protected function componentIndex(int $component = -1): int
    {
        return Arr::getKey($this->components, $component, -1);
    }

    /**
     * Gets the key for the component.
     *
     * @param  int  $component
     *
     * @return string|null
     */
    protected function componentKey(int $component = -1): ?string
    {
        return Arr::get($this->components, $component);
    }
}
