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

namespace Tests\Unit\Http\Builder;

use DragonCode\Support\Facades\Http\Builder;

class ToArrayMethodTest extends Base
{
    public function testShort()
    {
        $builder = Builder::parse($this->test_url);

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
        $builder = Builder::parse($this->psr_url);

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
        $builder = Builder::same();

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
