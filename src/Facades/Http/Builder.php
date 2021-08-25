<?php

/******************************************************************************
 * This file is part of the "andrey-helldar/support" project.                 *
 *                                                                            *
 * @author Andrey Helldar <helldar@ai-rus.com>                                *
 *                                                                            *
 * @copyright 2021 Andrey Helldar                                             *
 *                                                                            *
 * @license MIT                                                               *
 *                                                                            *
 * @see https://github.com/andrey-helldar/support                             *
 *                                                                            *
 * For the full copyright and license information, please view the LICENSE    *
 * file that was distributed with this source code.                           *
 ******************************************************************************/

namespace Helldar\Support\Facades\Http;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Helpers\Http\Builder as Support;
use Psr\Http\Message\UriInterface;

/**
 * @method static array toArray()
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
 * @method static Support fromPsr(UriInterface $uri)
 * @method static Support parse(string|UriInterface $url, int $component = Support::PHP_URL_ALL)
 * @method static Support parsed(array $parsed)
 * @method static Support putQuery(string $key, mixed $value)
 * @method static Support removeFragment()
 * @method static Support removeQuery(string $key)
 * @method static Support same()
 * @method static Support withFragment(string $fragment)
 * @method static Support withHost(string $host)
 * @method static Support withPath(string $path)
 * @method static Support withPort(int|null $host)
 * @method static Support withQuery(array|string $path)
 * @method static Support withScheme(string $scheme)
 * @method static Support withUserInfo(string $user, string $password = null)
 * @method static UriInterface toPsr()
 */
class Builder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Support::class;
    }
}
