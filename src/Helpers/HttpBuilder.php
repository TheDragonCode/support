<?php

namespace Helldar\Support\Helpers;

use ArgumentCountError;
use Helldar\Support\Facades\Helpers\Arr as ArrFacade;
use Helldar\Support\Facades\Helpers\Http as HttpHelper;
use Helldar\Support\Facades\Helpers\Str as StrFacade;
use RuntimeException;

/**
 * Based on code by Maksim (Ellrion) Platonov.
 *
 * @see https://gist.github.com/Ellrion/f51ba0d40ae1d62eeae44fd1adf7b704
 *
 * @method HttpBuilder setFragment(array|string $value)
 * @method HttpBuilder setHost(string $value)
 * @method HttpBuilder setPass(string $value)
 * @method HttpBuilder setPath(string $value)
 * @method HttpBuilder setPort(string $value)
 * @method HttpBuilder setQuery(array|string $value)
 * @method HttpBuilder setScheme(string $value)
 * @method HttpBuilder setUser(string $value)
 * @method string|null getFragment()
 * @method string|null getHost()
 * @method string|null getPass()
 * @method string|null getPath()
 * @method string|null getPort()
 * @method string|null getQuery()
 * @method string|null getScheme()
 * @method string|null getUser()
 */
final class HttpBuilder
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

    /**
     * Calling magic methods.
     *
     * @param  string  $method
     * @param  mixed  $args
     *
     * @return $this|string|null
     */
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

                    return $this->set($key, $args[0]);
            }
        }

        throw new RuntimeException("Using an unknown method: \"{$method}\"");
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
     * @param  string  $url
     * @param  int  $component
     *
     * @return $this
     */
    public function parse(string $url, int $component = -1): self
    {
        if ($component === -1) {
            HttpHelper::validateUrl($url);
        }

        $component = $this->componentIndex($component);
        $key       = $this->componentKey($component);

        $component === -1 || empty($key)
            ? $this->parsed = parse_url($url)
            : $this->parsed[$key] = parse_url($url, $component);

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
        foreach ($parsed as $key => $value) {
            if (! $this->allowKey($key)) {
                throw new RuntimeException('Filling in the "' . $key . '" key is prohibited.');
            }

            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * Compiles parameters to URL.
     *
     * @return string
     */
    public function compile(): string
    {
        return implode('', array_filter($this->prepare()));
    }

    /**
     * Prepares data for compilation.
     *
     * @return array
     */
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

    /**
     * Gets the index of the component.
     *
     * @param  int  $component
     *
     * @return int
     */
    protected function componentIndex(int $component = -1): int
    {
        return ArrFacade::getKey($this->components, $component, -1);
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
        return ArrFacade::get($this->components, $component);
    }

    /**
     * Checks if calling the requested key is allowed.
     *
     * @param  string|null  $key
     *
     * @return bool
     */
    protected function allowKey(?string $key): bool
    {
        return in_array($key, $this->components);
    }

    /**
     * Checks if the method is a request for information.
     *
     * @param  string  $method
     *
     * @return bool
     */
    protected function isGetter(string $method): bool
    {
        return StrFacade::startsWith($method, 'get');
    }

    /**
     * Checks if the method is a request to fill information.
     *
     * @param  string  $method
     *
     * @return bool
     */
    protected function isSetter(string $method): bool
    {
        return StrFacade::startsWith($method, 'set');
    }

    /**
     * Gets the key of the component from the name of the magic method.
     *
     * @param  string  $method
     *
     * @return string|null
     */
    protected function parseKey(string $method): ?string
    {
        $search = StrFacade::startsWith($method, 'get') ? 'get' : 'set';

        return StrFacade::lower(StrFacade::after($method, $search));
    }

    /**
     * Set the component key with a value.
     *
     * @param  string  $key
     * @param  mixed  $value
     *
     * @return $this
     */
    protected function set(string $key, $value): self
    {
        $this->parsed[$key] = is_array($value) ? http_build_query($value) : $value;

        return $this;
    }

    /**
     * Gets the value of the component.
     *
     * @param  string  $key
     *
     * @return string|null
     */
    protected function get(string $key): ?string
    {
        return $this->parsed[$key] ?? null;
    }

    /**
     * Checks the number of arguments passed.
     *
     * @param  string  $method
     * @param  array  $args
     * @param  int  $need
     */
    protected function validateArgumentsCount(string $method, array $args, int $need = 1): void
    {
        if (count($args) > 1) {
            throw new ArgumentCountError($method . ' expects at most ' . $need . ' parameter, ' . count($args) . ' given.');
        }
    }
}
