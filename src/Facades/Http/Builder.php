<?php

namespace Helldar\Support\Facades\Http;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Helpers\Http\Builder as Support;
use Psr\Http\Message\UriInterface;

/**
 * @method static int|null getPort()
 * @method static string getAuthority()
 * @method static string getBaseUrl()
 * @method static string getDomain()
 * @method static string getFragment()
 * @method static string getHost()
 * @method static string getPassword()
 * @method static string getPath()
 * @method static string getQuery()
 * @method static string getScheme()
 * @method static string getSubDomain()
 * @method static string getUser()
 * @method static string getUserInfo()
 * @method static Support fromPsr(UriInterface $uri)
 * @method static Support parse(UriInterface|string $url, int $component = Support::PHP_URL_ALL)
 * @method static Support parsed(array $parsed)
 * @method static Support putQuery(string $key, mixed $value)
 * @method static Support removeFragment()
 * @method static Support removeQuery(string $key)
 * @method static Support same()
 * @method static Support toArray()
 * @method static Support toPsr()
 * @method static Support toUrl()
 * @method static Support withFragment(string $fragment)
 * @method static Support withHost(string $host)
 * @method static Support withPath(string $path)
 * @method static Support withPort(string $port)
 * @method static Support withQuery(string $query)
 * @method static Support withScheme(string $scheme)
 * @method static Support withUserInfo(string $user, string $password = null)
 */
class Builder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
