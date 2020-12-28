<?php

namespace Helldar\Support\Helpers;

use Helldar\Support\Concerns\Makeable;

/**
 * Based on Maxim Ellrion's code.
 *
 * @see https://gist.github.com/Ellrion/f51ba0d40ae1d62eeae44fd1adf7b704
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

    public function parse(string $url, int $component = -1): self
    {
        $component = $this->componentIndex($component);
        $key       = $this->componentKey($component);

        $component === -1 || empty($key)
            ? $this->parsed       = parse_url($url)
            : $this->parsed[$key] = parse_url($url, $component);

        return $this;
    }

    public function getScheme(): ?string
    {
        return $this->get('scheme');
    }

    public function getHost(): ?string
    {
        return $this->get('host');
    }

    public function getPort(): ?string
    {
        return $this->get('port');
    }

    public function getUser(): ?string
    {
        return $this->get('user');
    }

    public function getPassword(): ?string
    {
        return $this->get('pass');
    }

    public function getPath(): ?string
    {
        return $this->get('path');
    }

    public function getQuery(): ?string
    {
        return $this->get('query');
    }

    public function getFragment(): ?string
    {
        return $this->get('fragment');
    }

    public function compile(): string
    {
        return implode('', $this->prepare());
    }

    protected function prepare(): array
    {
        return [
            $this->getScheme() ? $this->getScheme() . '://' : '',
            $this->getUser(),
            $this->getPassword() ? $this->getPassword() . '@' : '',
            $this->getHost(),
            $this->getPort() ? ':' . $this->getPort() : '',
            $this->getPath() ? '/' . ltrim($this->getPath()) : '',
            $this->getQuery() ? '?' . $this->getQuery() : '',
            $this->getFragment() ? '#' . $this->getFragment() : '',
        ];
    }

    protected function get(string $key): ?string
    {
        return Arr::get($this->parsed, $key);
    }

    protected function componentIndex(int $component = -1): int
    {
        return isset($this->components[$component]) ? $component : -1;
    }

    protected function componentKey(int $component = -1): ?string
    {
        return $this->components[$component] ?? null;
    }
}
