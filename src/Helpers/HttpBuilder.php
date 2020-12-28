<?php

namespace Helldar\Support\Helpers;

use ArgumentCountError;
use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Str;
use RuntimeException;

/**
 * Based on code by Maksim (Ellrion) Platonov.
 *
 * @see https://gist.github.com/Ellrion/f51ba0d40ae1d62eeae44fd1adf7b704
 *
 * @method string|null getFragment()
 * @method string|null getHost()
 * @method string|null getPass()
 * @method string|null getPath()
 * @method string|null getPort()
 * @method string|null getQuery()
 * @method string|null getScheme()
 * @method string|null getUser()
 * @method HttpBuilder setFragment(string $value)
 * @method HttpBuilder setHost(string $value)
 * @method HttpBuilder setPass(string $value)
 * @method HttpBuilder setPath(string $value)
 * @method HttpBuilder setPort(string $value)
 * @method HttpBuilder setQuery(string|array $value)
 * @method HttpBuilder setScheme(string $value)
 * @method HttpBuilder setUser(string $value)
 */
final class HttpBuilder
{
    use Makeable;

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

    public function __call($method, $args)
    {
        if ($this->isGetter($method) || $this->isSetter($method)) {
            $key = $this->parseKey($method);

            if (! $this->allowKey($key)) {
                throw new RuntimeException($method . ' method not defined.');
            }

            switch (true) {
                case $this->isGetter($method):
                    $this->validateArgumentsCount($method, $args, 0);

                    return $this->get($key);

                case $this->isSetter($method):
                    $this->validateArgumentsCount($method, $args);

                    return $this->set($key, ...$args);
            }
        }
    }

    public function same(): self
    {
        return $this;
    }

    public function parse(string $url, int $component = -1): self
    {
        $component = $this->componentIndex($component);
        $key       = $this->componentKey($component);

        $component === -1 || empty($key)
            ? $this->parsed = parse_url($url)
            : $this->parsed[$key] = parse_url($url, $component);

        return $this;
    }

    public function compile(): string
    {
        return implode('', array_filter($this->prepare()));
    }

    protected function prepare(): array
    {
        return [
            $this->getScheme() ? $this->getScheme() . '://' : '',
            $this->getUser(),
            $this->getPass() ? ':' . $this->getPass() : '',
            $this->getUser() || $this->getPass() ? '@' : '',
            $this->getHost(),
            $this->getPort() ? ':' . $this->getPort() : '',
            $this->getPath() ? '/' . ltrim($this->getPath(), '/') : '',
            $this->getQuery() ? '?' . $this->getQuery() : '',
            $this->getFragment() ? '#' . $this->getFragment() : '',
        ];
    }

    protected function value(string $key): ?string
    {
        return Arr::get($this->parsed, $key);
    }

    protected function componentIndex(int $component = -1): int
    {
        return Arr::getKey($this->components, $component, -1);
    }

    protected function componentKey(int $component = -1): ?string
    {
        return Arr::get($this->components, $component);
    }

    protected function allowKey(?string $key): bool
    {
        return in_array($key, $this->components);
    }

    protected function isGetter(string $method): bool
    {
        return Str::startsWith($method, 'get');
    }

    protected function isSetter(string $method): bool
    {
        return Str::startsWith($method, 'set');
    }

    protected function parseKey(string $method): ?string
    {
        $search = Str::startsWith($method, 'get') ? 'get' : 'set';

        return Str::lower(Str::after($method, $search));
    }

    protected function set(string $key, $value): self
    {
        $this->parsed[$key] = is_array($value) ? http_build_query($value) : $value;

        return $this;
    }

    protected function get(string $key, ...$args): ?string
    {
        if (count($args) > 1) {
            throw new ArgumentCountError($key . ' expects at most 0 parameter, ' . count($args) . ' given');
        }

        return $this->parsed[$key] ?? null;
    }

    protected function validateArgumentsCount(string $method, $args, int $need = 1): void
    {
        if (count($args) > 1) {
            throw new ArgumentCountError($method . ' expects at most ' . $need . ' parameter, ' . count($args) . ' given.');
        }
    }
}
