<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2023 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Http;

use DragonCode\Contracts\Http\Builder as BuilderContract;
use DragonCode\Support\Concerns\Castable;
use DragonCode\Support\Concerns\Validation;
use DragonCode\Support\Exceptions\UnknownUrlComponentIndexException;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Facades\Http\Url as UrlHelper;
use DragonCode\Support\Helpers\Ables\Stringable;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\UriInterface;

class Builder implements BuilderContract
{
    use Castable;
    use Validation;

    protected array $parsed = [];

    protected array $components = [
        PHP_URL_SCHEME   => 'scheme',
        PHP_URL_HOST     => 'host',
        PHP_URL_PORT     => 'port',
        PHP_URL_USER     => 'user',
        PHP_URL_PASS     => 'pass',
        PHP_URL_QUERY    => 'query',
        PHP_URL_PATH     => 'path',
        PHP_URL_FRAGMENT => 'fragment',
    ];

    protected array $casts = [
        'query' => 'array',
        'port'  => 'integer',
    ];

    protected array $validate = [
        PHP_URL_SCHEME   => ['null', 'string'],
        PHP_URL_HOST     => ['null', 'string'],
        PHP_URL_PORT     => ['null', 'integer'],
        PHP_URL_USER     => ['null', 'string'],
        PHP_URL_PASS     => ['null', 'string'],
        PHP_URL_QUERY    => ['null', 'string', 'array'],
        PHP_URL_PATH     => ['null', 'string'],
        PHP_URL_FRAGMENT => ['null', 'string'],
    ];

    /**
     * Return the string representation as a URI reference.
     *
     * @return string
     */
    public function __toString(): string
    {
        return static::toUrl();
    }

    /**
     * Gets the current instance of the object.
     *
     * @return \DragonCode\Support\Http\Builder
     */
    public static function same(): self
    {
        return $this;
    }

    /**
     * Parse a URL.
     *
     * @param \Psr\Http\Message\UriInterface|string|null $url
     * @param int $component
     *
     * @return \DragonCode\Support\Http\Builder
     */
    public static function parse(mixed $url, int $component = self::PHP_URL_ALL): BuilderContract
    {
        if ($component === self::PHP_URL_ALL) {
            UrlHelper::validate($url);
        }

        $instance = static::resolveSame($component);

        $key = static::componentNameByIndex($component);

        return $component === self::PHP_URL_ALL || empty($key)
            ? $instance->parsed(parse_url($url))
            : $instance->parsed([$key => parse_url($url, $component)]);
    }

    /**
     * Populate an object with parsed data.
     *
     * @param array $parsed
     *
     * @return \DragonCode\Support\Http\Builder
     */
    public static function parsed(array $parsed): BuilderContract
    {
        $components = array_values(static::components);

        $filtered = Arr::only($parsed, $components);

        static::parsed = Arr::of(static::parsed)
            ->merge($filtered)
            ->toArray();

        static::cast(static::parsed);

        return $this;
    }

    /**
     * Retrieve the domain name of the URI.
     *
     * @return string
     */
    public static function getDomain(): string
    {
        return static::getHost();
    }

    /**
     * Retrieve the domain level name of the URI.
     *
     * @param int $level
     *
     * @return string
     */
    public static function getDomainLevel(int $level = 0): string
    {
        return Str::of(static::getHost())
            ->explode('.')
            ->reverse()
            ->get($level - 1, '');
    }

    /**
     * Retrieve the base domain name of the URI.
     *
     * @return string
     */
    public static function getBaseDomain(): string
    {
        $first  = static::getDomainLevel(1);
        $second = static::getDomainLevel(2);

        if ($first && $second) {
            return $second . '.' . $first;
        }

        return '';
    }

    /**
     * Retrieve the subdomain name of the URI.
     *
     * @return string
     */
    public static function getSubDomain(): string
    {
        return Str::of(static::getHost())
            ->when(
                fn ($host) => Str::count($host, '.') > 1,
                fn (Stringable $string) => $string
                    ->explode('.')
                    ->splice(-2)
                    ->implode('.')
            )->toString();
    }

    /**
     * Retrieve the scheme and host of the URI.
     *
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return Str::of('://')
            ->prepend(static::getScheme())
            ->append(static::getHost())
            ->trim('://')
            ->toString();
    }

    /**
     * Retrieve the scheme component of the URI.
     *
     * @return string
     */
    public static function getScheme(): string
    {
        return (string) static::get(PHP_URL_SCHEME);
    }

    /**
     * Retrieve the authority component of the URI.
     *
     * @return string
     */
    public static function getAuthority(): string
    {
        $auth = static::getUserInfo();
        $host = static::getHost();
        $port = static::getPort();

        return (string) Str::of("$auth@$host:$port")->trim('@:');
    }

    /**
     * Retrieve the user information component of the URI.
     *
     * @return string
     */
    public static function getUserInfo(): string
    {
        $user = static::getUser();
        $pass = static::getPassword();

        return (string) Str::of("$user:$pass")->trim(':');
    }

    /**
     * Retrieve the user name component of the URI.
     *
     * @return string
     */
    public static function getUser(): string
    {
        return (string) static::get(PHP_URL_USER);
    }

    /**
     * Retrieve the user password component of the URI.
     *
     * @return string
     */
    public static function getPassword(): string
    {
        return (string) static::get(PHP_URL_PASS);
    }

    /**
     * Retrieve the host component of the URI.
     *
     * @return string
     */
    public static function getHost(): string
    {
        return (string) static::get(PHP_URL_HOST);
    }

    /**
     * Retrieve the port component of the URI.
     *
     * @return int|null
     */
    public static function getPort(): ?int
    {
        return static::get(PHP_URL_PORT);
    }

    /**
     * Retrieve the path component of the URI.
     *
     * @return string
     */
    public static function getPath(): string
    {
        $value = static::get(PHP_URL_PATH);

        return Str::of($value)
            ->trim('/')
            ->start('/')
            ->when(
                fn (Stringable $path) => $path->toString() !== '/',
                fn (Stringable $path) => $path,
                ''
            );
    }

    /**
     * Retrieve the query string of the URI.
     *
     * @return string
     */
    public static function getQuery(): string
    {
        if ($value = static::get(PHP_URL_QUERY)) {
            return is_string($value) ? $value : http_build_query($value);
        }

        return '';
    }

    /**
     * Retrieve the query array of the URI.
     *
     * @return array
     */
    public static function getQueryArray(): array
    {
        if ($value = static::get(PHP_URL_QUERY)) {
            return $value;
        }

        return [];
    }

    /**
     * Retrieve the fragment component of the URI.
     *
     * @return string
     */
    public static function getFragment(): string
    {
        return (string) static::get(PHP_URL_FRAGMENT);
    }

    /**
     * Remove the fragment component from the URI.
     *
     * @return \DragonCode\Support\Http\Builder
     */
    public static function removeFragment(): BuilderContract
    {
        return static::set(PHP_URL_FRAGMENT, null);
    }

    /**
     * Return an instance with the specified scheme.
     *
     * @param string $scheme
     *
     * @return \DragonCode\Support\Http\Builder
     */
    public static function withScheme($scheme): self
    {
        return static::set(PHP_URL_SCHEME, $scheme);
    }

    /**
     * Return an instance with the specified user information.
     *
     * @param string $user
     * @param string|null $password
     *
     * @return \DragonCode\Support\Http\Builder
     */
    public static function withUserInfo($user, $password = null): self
    {
        return $this
            ->set(PHP_URL_USER, $user)
            ->set(PHP_URL_PASS, $password);
    }

    /**
     * Return an instance with the specified host.
     *
     * @param string $host
     *
     * @return \DragonCode\Support\Http\Builder
     */
    public static function withHost($host): self
    {
        return static::set(PHP_URL_HOST, $host);
    }

    /**
     * Return an instance with the specified port.
     *
     * @param int|null $port
     *
     * @return \DragonCode\Support\Http\Builder
     */
    public static function withPort($port): self
    {
        return static::set(PHP_URL_PORT, $port);
    }

    /**
     * Return an instance with the specified path.
     *
     * @param string $path
     *
     * @return \DragonCode\Support\Http\Builder
     */
    public static function withPath($path): self
    {
        return static::set(PHP_URL_PATH, $path);
    }

    /**
     * Return an instance with the specified query string.
     *
     * @param array|string $query
     *
     * @return \DragonCode\Support\Http\Builder
     */
    public static function withQuery($query): self
    {
        return static::set(PHP_URL_QUERY, $query);
    }

    /**
     * Return an instance with the specified query object.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return \DragonCode\Support\Http\Builder
     */
    public static function putQuery(string $key, $value): BuilderContract
    {
        $query = static::get(PHP_URL_QUERY);

        if (empty($value)) {
            $value = is_array($value) ? []
                : (! is_numeric($value) ? null : $value);
        }

        $query = Arr::set($query, $key, $value);

        return static::set(PHP_URL_QUERY, $query);
    }

    /**
     * Return an instance with the specified query object.
     *
     * @param string $key
     *
     * @return \DragonCode\Support\Http\Builder
     */
    public static function removeQuery(string $key): BuilderContract
    {
        $query = static::get(PHP_URL_QUERY);

        unset($query[$key]);

        return static::set(PHP_URL_QUERY, $query);
    }

    /**
     * Return an instance with the specified URI fragment.
     *
     * @param string $fragment
     *
     * @return \DragonCode\Support\Http\Builder
     */
    public static function withFragment($fragment): self
    {
        return static::set(PHP_URL_FRAGMENT, $fragment);
    }

    /**
     * Return an instance with the specified `UriInterface`.
     *
     * @param \Psr\Http\Message\UriInterface $uri
     *
     * @return \DragonCode\Support\Http\Builder
     */
    public static function fromPsr(UriInterface $uri): BuilderContract
    {
        static::parsed = [];

        static::withScheme($uri->getScheme());
        static::withHost($uri->getHost());
        static::withPort($uri->getPort());
        static::withPath($uri->getPath());
        static::withQuery($uri->getQuery());
        static::withFragment($uri->getFragment());

        $auth = explode(':', $uri->getUserInfo());

        static::withUserInfo(
            $auth[0] ?? null,
            $auth[1] ?? null
        );

        static::cast(static::parsed);

        return $this;
    }

    /**
     * Return the string representation as a URI reference.
     *
     * @return \Psr\Http\Message\UriInterface
     */
    public static function toPsr(): UriInterface
    {
        return static::same();
    }

    /**
     * Returns parsed data.
     *
     * @return null[]|string[]
     */
    public static function toArray(): array
    {
        return [
            'scheme'   => static::getScheme(),
            'user'     => static::getUser(),
            'pass'     => static::getPassword(),
            'host'     => static::getHost(),
            'port'     => static::getPort(),
            'path'     => static::getPath(),
            'query'    => static::getQuery(),
            'fragment' => static::getFragment(),
        ];
    }

    /**
     * Return the string representation as a URI reference.
     *
     * @return string
     */
    public static function toUrl(): string
    {
        return Arr::of(static::prepare())
            ->map(static fn (mixed $value) => (string) $value)
            ->filter()
            ->implode('')
            ->when(fn (Stringable $url) => $url->toString() === '//', '', fn ($url) => $url)
            ->toString();
    }

    protected function componentNameByIndex(int $component): ?string
    {
        static::validateComponentIndex($component);

        return Arr::get(static::components, $component);
    }

    protected function validateComponentIndex(int $component): void
    {
        $components = array_keys(static::components);

        if ($component !== self::PHP_URL_ALL && ! in_array($component, $components, true)) {
            throw new UnknownUrlComponentIndexException($component);
        }
    }

    protected function set(int $component, $value): self
    {
        static::validate($component, $value);

        $name = static::componentNameByIndex($component);

        static::parsed[$name] = static::castValue($name, $value);

        return $this;
    }

    protected function get(int $index)
    {
        $name = static::componentNameByIndex($index);

        return Arr::get(static::parsed, $name);
    }

    protected function getValidationType(int $component): array
    {
        return Arr::get(static::validate, $component, []);
    }

    protected function validate(int $component, $value): void
    {
        $type = static::getValidationType($component);

        static::validateType($value, $type);
    }

    /**
     * Based on code by Maksim (Ellrion) Platonov.
     *
     * @see https://gist.github.com/Ellrion/f51ba0d40ae1d62eeae44fd1adf7b704
     *
     * @return array
     */
    protected function prepare(): array
    {
        return [
            BuilderPrepare::make()->of(static::getScheme())->suffix(':'),

            '//',

            BuilderPrepare::make()->of(static::getUser()),
            BuilderPrepare::make()->of(static::getPassword())->prefix(':'),

            static::getUser() || static::getPassword() ? '@' : '',

            BuilderPrepare::make()->of(static::getHost()),
            BuilderPrepare::make()->of(static::getPort())->prefix(':'),
            BuilderPrepare::make()->of(static::getPath()),
            BuilderPrepare::make()->of(static::getQuery())->prefix('?'),
            BuilderPrepare::make()->of(static::getFragment())->prefix('#'),
        ];
    }

    #[Pure]
    protected function resolveSame(int $component = self::PHP_URL_ALL): self
    {
        return $component === self::PHP_URL_ALL ? new self() : $this;
    }
}
