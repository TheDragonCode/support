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

namespace Tests\Unit\Instances\Helpers\Http;

use Tests\Fixtures\Instances\Psr;
use Tests\TestCase;

abstract class Base extends TestCase
{
    protected string $test_url = 'https://en.example.com/';

    protected string $psr_url = 'https://foo:bar@en.example.com:8901/foo/bar?id=123&name=hey#qwerty';

    protected string $psr_scheme = 'https';

    protected string $psr_user = 'foo';

    protected string $psr_pass = 'bar';

    protected string $psr_host = 'en.example.com';

    protected int $psr_port = 8901;

    protected string $psr_path = '/foo/bar';

    protected string $psr_query = 'id=123&name=hey';

    protected array $psr_query_array = [
        'id'   => '123',
        'name' => 'hey',
    ];

    protected string $psr_fragment = 'qwerty';

    protected function psr(bool $empty = false): Psr
    {
        if ($empty) {
            return Psr::make();
        }

        return Psr::make()
            ->withScheme($this->psr_scheme)
            ->withUserInfo($this->psr_user, $this->psr_pass)
            ->withHost($this->psr_host)
            ->withPort($this->psr_port)
            ->withPath($this->psr_path)
            ->withQuery($this->psr_query)
            ->withFragment($this->psr_fragment);
    }
}
