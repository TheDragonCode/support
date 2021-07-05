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
 * @method static string toUrl()
 * @method static Support fromPsrUrl(UriInterface $uri)
 * @method static Support parse($url, int $component = Support::PHP_URL_ALL)
 * @method static Support parsed(array $parsed)
 * @method static Support putQuery(string $key, mixed $value)
 * @method static Support removeQuery(string $key)
 * @method static Support same()
 * @method static Support withFragment(string $fragment)
 * @method static Support withHost(string $host)
 * @method static Support withPath(string $path)
 * @method static Support withPort(int|null $host)
 * @method static Support withQuery(array|string $path)
 * @method static Support withScheme(string $scheme)
 * @method static Support withUserInfo(string $user, string $password = null)
 * @method static UriInterface toPsrUrl()
 */
class Builder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
