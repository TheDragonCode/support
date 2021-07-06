<?php

namespace Tests\Fixtures\Instances;

use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Helldar\Support\Facades\Helpers\Str;
use Helldar\Support\Tools\HttpBuilderPrepare;
use Psr\Http\Message\UriInterface;

class Psr implements UriInterface
{
    use Makeable;

    protected $scheme = '';

    protected $user = '';

    protected $password = '';

    protected $host = '';

    protected $port;

    protected $path = '';

    protected $query = '';

    protected $fragment = '';

    public function __toString()
    {
        $items = Arrayable::of($this->prepare())
            ->map(function ($value) {
                return (string) $value;
            })
            ->filter()
            ->get();

        return implode('', $items);
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function getAuthority(): string
    {
        $auth = $this->getUserInfo();
        $host = $this->getHost();
        $port = $this->getPort();

        return (string) Str::of("$auth@$host:$port")->trim('@:');
    }

    public function getUserInfo(): string
    {
        $user = $this->user;
        $pass = $this->password;

        return (string) Str::of("$user:$pass")->trim(':');
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getFragment(): string
    {
        return $this->fragment;
    }

    public function withScheme($scheme): self
    {
        $this->scheme = $scheme;

        return $this;
    }

    public function withUserInfo($user, $password = null): self
    {
        $this->user     = $user;
        $this->password = $password;

        return $this;
    }

    public function withHost($host): self
    {
        $this->host = $host;

        return $this;
    }

    public function withPort($port): self
    {
        $this->port = $port;

        return $this;
    }

    public function withPath($path): self
    {
        $this->path = $path;

        return $this;
    }

    public function withQuery($query): self
    {
        $this->query = $query;

        return $this;
    }

    public function withFragment($fragment): self
    {
        $this->fragment = $fragment;

        return $this;
    }

    protected function prepare(): array
    {
        return [
            HttpBuilderPrepare::make()->of($this->getScheme())->suffix(':'),

            '//',

            HttpBuilderPrepare::make()->of($this->user),
            HttpBuilderPrepare::make()->of($this->password)->prefix(':'),

            $this->user || $this->password ? '@' : '',

            HttpBuilderPrepare::make()->of($this->getHost()),
            HttpBuilderPrepare::make()->of($this->getPort())->prefix(':'),
            HttpBuilderPrepare::make()->of($this->getPath()),
            HttpBuilderPrepare::make()->of($this->getQuery())->prefix('?'),
            HttpBuilderPrepare::make()->of($this->getFragment())->prefix('#'),
        ];
    }
}
