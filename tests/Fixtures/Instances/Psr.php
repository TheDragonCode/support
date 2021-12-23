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

namespace Tests\Fixtures\Instances;

use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Tools\HttpBuilderPrepare;
use Psr\Http\Message\UriInterface;

class Psr implements UriInterface
{
    use Makeable;

    protected string $scheme = '';

    protected string $user = '';

    protected string $password = '';

    protected string $host = '';

    protected ?int $port = null;

    protected string $path = '';

    protected string $query = '';

    protected string $fragment = '';

    public function __toString(): string
    {
        return (string) Arr::of($this->prepare())
            ->map(static fn ($value): string => (string) $value)
            ->filter()
            ->implode('');
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
