<?php

namespace Helldar\Support\Helpers\Http;

use Helldar\Support\Concerns\Validation;
use Helldar\Support\Exceptions\UnknownUrlComponentIndexException;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Str;
use Helldar\Support\Facades\Http\Url as UrlHelper;
use Psr\Http\Message\UriInterface;

class Builder implements UriInterface
{
    use Validation;

    public const PHP_URL_ALL = -1;

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
        'query' => 'array',
        'port'  => 'integer',
    ];

    protected $validate = [
        PHP_URL_SCHEME   => ['string'],
        PHP_URL_HOST     => ['string'],
        PHP_URL_PORT     => ['integer'],
        PHP_URL_USER     => ['string'],
        PHP_URL_PASS     => ['string'],
        PHP_URL_QUERY    => ['string', 'array'],
        PHP_URL_PATH     => ['string'],
        PHP_URL_FRAGMENT => ['string'],
    ];

    /**
     * Return the string representation as a URI reference.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toUrl();
    }

    /**
     * Gets the current instance of the object.
     *
     * @return \Helldar\Support\Helpers\Http\Builder
     */
    public function same(): self
    {
        return $this;
    }

    /**
     * Parse a URL.
     *
     * @param  \Psr\Http\Message\UriInterface|string|null  $url
     * @param  int  $component
     *
     * @return \Helldar\Support\Helpers\Http\Builder
     */
    public function parse($url, int $component = self::PHP_URL_ALL): self
    {
        if ($component === self::PHP_URL_ALL) {
            UrlHelper::validate($url);
        }

        $key = $this->componentNameByIndex($component);

        $component === self::PHP_URL_ALL || empty($key)
            ? $this->parsed       = parse_url($url)
            : $this->parsed[$key] = parse_url($url, $component);

        $this->cast();

        return $this;
    }

    /**
     * Populate an object with parsed data.
     *
     * @param  array  $parsed
     *
     * @return \Helldar\Support\Helpers\Http\Builder
     */
    public function parsed(array $parsed): self
    {
        $components = array_values($this->components);

        $this->parsed = Arr::only($parsed, $components);

        $this->cast();

        return $this;
    }

    /**
     * Retrieve the domain name of the URI.
     *
     * @return string
     */
    public function getDomain(): string
    {
        return $this->getHost();
    }

    /**
     * Retrieve the subdomain name of the URI.
     *
     * @return string
     */
    public function getSubDomain(): string
    {
        $host = explode('.', $this->getHost());

        return count($host) > 2 ? reset($host) : '';
    }

    /**
     * Retrieve the scheme and host of the URI.
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        $schema = $this->getScheme();
        $host   = $this->getHost();

        return (string) Str::of("$schema://$host")->trim('://');
    }

    /**
     * Retrieve the scheme component of the URI.
     *
     * @return string
     */
    public function getScheme(): string
    {
        return $this->get(PHP_URL_SCHEME);
    }

    /**
     * Retrieve the authority component of the URI.
     *
     * @return string
     */
    public function getAuthority(): string
    {
        $auth = $this->getUserInfo();
        $host = $this->getHost();
        $port = $this->getPort();

        return (string) Str::of("$auth@$host:$port")->trim('@:');
    }

    /**
     * Retrieve the user information component of the URI.
     *
     * @return string
     */
    public function getUserInfo(): string
    {
        $user = $this->getUser();
        $pass = $this->getPassword();

        return (string) Str::of("$user:$pass")->trim(':');
    }

    /**
     * Retrieve the user name component of the URI.
     *
     * @return string
     */
    public function getUser(): string
    {
        return $this->get(PHP_URL_USER);
    }

    /**
     * Retrieve the user password component of the URI.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->get(PHP_URL_PASS);
    }

    /**
     * Retrieve the host component of the URI.
     *
     * @return string
     */
    public function getHost(): string
    {
        return $this->get(PHP_URL_HOST);
    }

    /**
     * Retrieve the port component of the URI.
     *
     * @return int|null
     */
    public function getPort(): ?int
    {
        return $this->get(PHP_URL_PORT);
    }

    /**
     * Retrieve the path component of the URI.
     *
     * @return string
     */
    public function getPath(): string
    {
        $value = $this->get(PHP_URL_PATH);

        return (string) Str::start($value, '/');
    }

    /**
     * Retrieve the query string of the URI.
     *
     * @return string
     */
    public function getQuery(): string
    {
        return $this->get(PHP_URL_QUERY);
    }

    /**
     * Retrieve the fragment component of the URI.
     *
     * @return string
     */
    public function getFragment(): string
    {
        return $this->get(PHP_URL_FRAGMENT);
    }

    /**
     * Return an instance with the specified scheme.
     *
     * @param  string  $scheme
     *
     * @return \Helldar\Support\Helpers\Http\Builder
     */
    public function withScheme($scheme): self
    {
        return $this->set(PHP_URL_SCHEME, $scheme);
    }

    /**
     * Return an instance with the specified user information.
     *
     * @param  string  $user
     * @param  string|null  $password
     *
     * @return \Helldar\Support\Helpers\Http\Builder
     */
    public function withUserInfo($user, $password = null): self
    {
        return $this
            ->set(PHP_URL_USER, $user)
            ->set(PHP_URL_PASS, $password);
    }

    /**
     * Return an instance with the specified host.
     *
     * @param  string  $host
     *
     * @return \Helldar\Support\Helpers\Http\Builder
     */
    public function withHost($host): self
    {
        return $this->set(PHP_URL_HOST, $host);
    }

    /**
     * Return an instance with the specified port.
     *
     * @param  int|null  $port
     *
     * @return \Helldar\Support\Helpers\Http\Builder
     */
    public function withPort($port): self
    {
        return $this->set(PHP_URL_PORT, $port);
    }

    /**
     * Return an instance with the specified path.
     *
     * @param  string  $path
     *
     * @return \Helldar\Support\Helpers\Http\Builder
     */
    public function withPath($path): self
    {
        return $this->set(PHP_URL_PATH, $path);
    }

    /**
     * Return an instance with the specified query string.
     *
     * @param  string  $query
     *
     * @return \Helldar\Support\Helpers\Http\Builder
     */
    public function withQuery($query): self
    {
        return $this->set(PHP_URL_QUERY, $query);
    }

    /**
     * Return an instance with the specified query object.
     *
     * @param  string  $key
     * @param  mixed  $value
     *
     * @return \Helldar\Support\Helpers\Http\Builder
     */
    public function putQuery(string $key, $value): self
    {
        $query = $this->get(PHP_URL_QUERY);

        $query[$key] = $value;

        return $this->set(PHP_URL_QUERY, $query);
    }

    /**
     * Return an instance with the specified query object.
     *
     * @param  string  $key
     *
     * @return \Helldar\Support\Helpers\Http\Builder
     */
    public function removeQuery(string $key): self
    {
        unset($this->parsed[$key]);

        return $this;
    }

    /**
     * Return an instance with the specified URI fragment.
     *
     * @param  string  $fragment
     *
     * @return \Helldar\Support\Helpers\Http\Builder
     */
    public function withFragment($fragment): self
    {
        return $this->set(PHP_URL_FRAGMENT, $fragment);
    }

    /**
     * Return an instance with the specified `UriInterface`.
     *
     * @param  \Psr\Http\Message\UriInterface  $uri
     *
     * @return $this
     */
    public function fromPsrUrl(UriInterface $uri): self
    {
        return $this->parse($uri);
    }

    /**
     * Return the string representation as a URI reference.
     *
     * @return \Psr\Http\Message\UriInterface
     */
    public function toPsrUrl(): UriInterface
    {
        $url = clone $this->same();

        $key = $this->componentNameByIndex(PHP_URL_QUERY);

        if (isset($url->parsed[$key])) {
            $url->parsed[$key] = http_build_query($url->parsed[$key]);
        }

        return $url;
    }

    /**
     * Return the string representation as a URI reference.
     *
     * @return string
     */
    public function toUrl(): string
    {
        return (string) $this->toPsrUrl();
    }

    protected function componentNameByIndex(int $component): ?string
    {
        $this->validateComponentIndex($component);

        return Arr::get($this->components, $component);
    }

    protected function validateComponentIndex(int $component): void
    {
        $components = array_keys($this->components);

        if ($component !== self::PHP_URL_ALL && ! in_array($component, $components, true)) {
            throw new UnknownUrlComponentIndexException($component);
        }
    }

    protected function cast(): void
    {
        Arrayable::of($this->parsed)
            ->map(function (&$value, string $key) {
                switch ($this->casts[$key] ?? null) {
                    case 'array':
                        $value = $this->castToArray($value);
                        break;

                    case 'integer':
                        $value = $this->castToInteger($value);
                        break;

                    default:
                        $value = $this->castToString($value);
                }
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

        foreach (explode('&', $value) as $index => $item) {
            [$key, $value] = Str::contains($item, '=') ? explode('=', $item) : [$index, $item];

            $items[$key] = $value;
        }

        return $items;
    }

    protected function castToInteger($value): ?int
    {
        return empty($value) && ! is_numeric($value) ? null : $value;
    }

    protected function castToString(?string $value): ?string
    {
        return $value ?: null;
    }

    protected function set(int $component, $value): self
    {
        $this->validate($component, $value);

        $name = $this->componentNameByIndex($component);

        $this->parsed[$name] = $value;

        $this->cast();

        return $this;
    }

    protected function get(int $index)
    {
        $name = $this->componentNameByIndex($index);

        return Arr::get($this->parsed, $name);
    }

    protected function getValidationType(int $component): array
    {
        return $this->validate[$component] ?? [];
    }

    protected function validate(int $component, $value): void
    {
        $type = $this->getValidationType($component);

        $this->validateType($value, $type);
    }
}
