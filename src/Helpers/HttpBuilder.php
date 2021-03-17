<?php

namespace Helldar\Support\Helpers;

use ArgumentCountError;
use Helldar\Support\Facades\Helpers\Arr as ArrFacade;
use Helldar\Support\Facades\Helpers\Http as HttpHelper;
use Helldar\Support\Facades\Helpers\Instance as InstanceHelper;
use Helldar\Support\Facades\Helpers\Str as StrFacade;
use Helldar\Support\Tools\HttpBuilderPrepare;
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
 * @method HttpBuilder putQuery(string $key, $value)
 * @method HttpBuilder removeQuery(string $key)
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

    protected $allow_put_remove = ['query'];

    protected $casts = [
        'query' => 'array',
    ];

    /**
     * Calling magic methods.
     *
     * @param  string  $method
     * @param  mixed  $args
     *
     * @return $this|string|null
     */
    public function __call(string $method, $args)
    {
        if ($this->isGetter($method) || $this->isSetter($method) || $this->isPutter($method) || $this->isRemover($method)) {
            $key = $this->parseKey($method);

            if (! $this->allowKey($key) || ! $this->allowArrayable($method, $key)) {
                throw new RuntimeException($method . ' method not defined.');
            }

            switch (true) {
                case $this->isGetter($method):
                    $this->validateArgumentsCount($method, $args, 0);

                    return $this->get($key);

                case $this->isSetter($method):
                    $this->validateArgumentsCount($method, $args);

                    return $this->set($key, $args[0]);

                case $this->isPutter($method):
                    $this->validateArgumentsCount($method, $args, 2);

                    return $this->put($key, $args[0], $args[1]);

                case $this->isRemover($method):
                    $this->validateArgumentsCount($method, $args);

                    return $this->remove($key, $args[0]);
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
     * @param  string|null  $url
     * @param  int  $component
     *
     * @return $this
     */
    public function parse(?string $url, int $component = -1): self
    {
        if ($component === -1) {
            HttpHelper::validateUrl($url);
        }

        $component = $this->componentIndex($component);
        $key       = $this->componentKey($component);

        $component === -1 || empty($key)
            ? $this->parsed = parse_url($url)
            : $this->parsed[$key] = parse_url($url, $component);

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
        foreach ($parsed as $key => $value) {
            if (! $this->allowKey($key)) {
                throw new RuntimeException('Filling in the "' . $key . '" key is prohibited.');
            }

            $this->set($key, $value);
        }

        $this->cast();

        return $this;
    }

    /**
     * Compiles parameters to URL.
     *
     * @return string
     */
    public function compile(): string
    {
        return implode('', array_filter(array_map(function ($value) {
            return InstanceHelper::of($value, HttpBuilderPrepare::class) ? $value->get() : $value;
        }, $this->prepare())));
    }

    /**
     * Returns parsed data.
     *
     * @return null[]|string[]
     */
    public function toArray(): array
    {
        return [
            'scheme'   => $this->getScheme(),
            'host'     => $this->getHost(),
            'port'     => $this->getPort(),
            'user'     => $this->getUser(),
            'pass'     => $this->getPass(),
            'query'    => $this->getQuery(),
            'path'     => $this->getPath(),
            'fragment' => $this->getFragment(),
        ];
    }

    /**
     * Prepares data for compilation.
     *
     * @return array
     */
    protected function prepare(): array
    {
        return [
            HttpBuilderPrepare::make()->of($this->getScheme())->suffix('://'),
            HttpBuilderPrepare::make()->of($this->getUser()),
            HttpBuilderPrepare::make()->of($this->getPass())->prefix(':'),

            $this->getUser() || $this->getPass() ? '@' : '',

            HttpBuilderPrepare::make()->of($this->getHost()),
            HttpBuilderPrepare::make()->of($this->getPort())->prefix(':'),
            HttpBuilderPrepare::make()->of($this->getPath())->prefix('/'),
            HttpBuilderPrepare::make()->of($this->getQuery())->prefix('?'),
            HttpBuilderPrepare::make()->of($this->getFragment())->prefix('#'),
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

    protected function allowArrayable(?string $method, ?string $key): bool
    {
        if ($this->isPutter($method) || $this->isRemover($method)) {
            return in_array($key, $this->allow_put_remove);
        }

        return true;
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
     * Checks if the method is a request to put value.
     *
     * @param  string  $method
     *
     * @return bool
     */
    protected function isPutter(string $method): bool
    {
        return StrFacade::startsWith($method, 'put');
    }

    /**
     * Checks if the method is a request to remove value.
     *
     * @param  string  $method
     *
     * @return bool
     */
    protected function isRemover(string $method): bool
    {
        return StrFacade::startsWith($method, 'remove');
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
        $search = 'unknown';

        switch (true) {
            case $this->isGetter($method):
                $search = 'get';
                break;

            case $this->isSetter($method):
                $search = 'set';
                break;

            case $this->isPutter($method):
                $search = 'put';
                break;

            case $this->isRemover($method):
                $search = 'remove';
                break;
        }

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
        switch (true) {
            case $this->hasCastArray($key):
                $value = $this->castToArray($value);
                break;
        }

        $this->parsed[$key] = $value;

        return $this;
    }

    /**
     * Gets the value of the component.
     *
     * @param  string  $key
     *
     * @return array|string|null
     */
    protected function get(string $key)
    {
        if ($value = $this->parsed[$key] ?? null) {
            return $this->hasCastArray($key) ? http_build_query($value) : $value;
        }

        return null;
    }

    /**
     * Adds a key-value to an array.
     *
     * @param  string  $key
     * @param  string  $parameter
     * @param  mixed  $value
     *
     * @return $this
     */
    protected function put(string $key, string $parameter, $value): self
    {
        $this->parsed[$key][$parameter] = $value;

        return $this;
    }

    /**
     * Removes a key from a variable.
     *
     * @param  string  $key
     * @param  string  $parameter
     *
     * @return $this
     */
    protected function remove(string $key, string $parameter): self
    {
        unset($this->parsed[$key][$parameter]);

        return $this;
    }

    protected function hasCastArray(string $key): bool
    {
        return ($this->casts[$key] ?? null) === 'array';
    }

    protected function cast(): void
    {
        foreach ($this->casts as $key => $cast) {
            $value = $this->parsed[$key] ?? null;

            switch ($cast) {
                case 'array':
                    $value = $this->castToArray($value);
                    break;
            }

            $this->parsed[$key] = $value;
        }
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
            [$key, $value] = StrFacade::contains($item, '=') ? explode('=', $item) : [0, $item];

            $items[$key] = $value;
        }

        return $items;
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
        if (count($args) > $need) {
            throw new ArgumentCountError($method . ' expects at most ' . $need . ' parameter, ' . count($args) . ' given.');
        }
    }
}
