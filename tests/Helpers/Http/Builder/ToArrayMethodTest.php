<?php
/*
 * This file is part of the "andrey-helldar/support" project.
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
 * @see https://github.com/andrey-helldar/support
 */

namespace Tests\Helpers\Http\Builder;

use Tests\Helpers\Http\Base;

class ToArrayMethodTest extends Base
{
    public function testShort()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsArray($builder->toArray());

        $this->assertSame([
            'scheme'   => 'https',
            'user'     => '',
            'pass'     => '',
            'host'     => 'en.example.com',
            'port'     => null,
            'path'     => '',
            'query'    => '',
            'fragment' => '',
        ], $builder->toArray());
    }

    public function testFull()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $this->assertIsArray($builder->toArray());

        $this->assertSame([
            'scheme'   => 'https',
            'user'     => 'foo',
            'pass'     => 'bar',
            'host'     => 'en.example.com',
            'port'     => 8901,
            'path'     => '/foo/bar',
            'query'    => 'id=123&name=hey',
            'fragment' => 'qwerty',
        ], $builder->toArray());
    }

    public function testEmpty()
    {
        $builder = $this->builder();

        $this->assertIsArray($builder->toArray());

        $this->assertSame([
            'scheme'   => '',
            'user'     => '',
            'pass'     => '',
            'host'     => '',
            'port'     => null,
            'path'     => '',
            'query'    => '',
            'fragment' => '',
        ], $builder->toArray());
    }
}
