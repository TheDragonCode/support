<?php

namespace Helldar\Support\Tools\Http;

use Helldar\Support\Concerns\Makeable;
use Helldar\Support\Facades\Helpers\Ables\Stringable;
use Helldar\Support\Helpers\HttpBuilder;
use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{
    use Makeable;

    /** @var \Helldar\Support\Helpers\HttpBuilder */
    protected $builder;

    public function __construct(HttpBuilder $builder = null)
    {
        $this->builder = $builder ?: new HttpBuilder();
    }

    public function getScheme(): ?string
    {
        return $this->builder->getScheme();
    }

    public function getAuthority(): ?string
    {
        $auth = $this->getUserInfo();
        $host = $this->getHost();
        $port = $this->getPort();

        $auth = $auth ? $auth . '@' : '';
        $port = $port ? ':' . $port : '';

        return $auth . $host . $port;
    }

    public function getUserInfo(): ?string
    {
        if (empty($this->builder->getUser()) && empty($this->builder->getUser())) {
            return null;
        }

        $user     = Stringable::of($this->builder->getUser())->trim();
        $password = Stringable::of($this->builder->getPass())->trim()->start(':');

        return $user . $password;
    }

    public function getHost(): ?string
    {
        return $this->builder->getHost();
    }

    public function getPort(): ?int
    {
        return $this->builder->getPort();
    }

    public function getPath(): ?string
    {
        return $this->builder->getPath();
    }

    public function getQuery(): ?string
    {
        return $this->builder->getQuery();
    }

    public function getFragment(): ?string
    {
        return $this->builder->getFragment();
    }

    public function withScheme($scheme): Uri
    {
        $this->builder->setScheme($scheme);

        return $this;
    }

    public function withUserInfo($user, $password = null): Uri
    {
        $this->builder->setUser($user);
        $this->builder->setPass($password);

        return $this;
    }

    public function withHost($host): Uri
    {
        $this->builder->setHost($host);

        return $this;
    }

    public function withPort($port): Uri
    {
        $this->builder->setPort($port);

        return $this;
    }

    public function withPath($path): Uri
    {
        $this->builder->setPath($path);

        return $this;
    }

    public function withQuery($query): Uri
    {
        $this->builder->setQuery($query);

        return $this;
    }

    public function withFragment($fragment): Uri
    {
        $this->builder->setFragment($fragment);

        return $this;
    }

    public function __toString()
    {
        return $this->builder->compile();
    }
}
