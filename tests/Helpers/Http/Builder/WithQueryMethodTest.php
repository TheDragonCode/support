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

namespace Tests\Helpers\Http\Builder;

use Tests\Helpers\Http\Base;

class WithQueryMethodTest extends Base
{
    public function testWithout()
    {
        $builder = $this->builder();

        $this->assertIsString($builder->getQuery());
        $this->assertEmpty($builder->getQuery());

        $builder->withQuery($this->psr_query);

        $this->assertIsString($builder->getQuery());
        $this->assertSame($this->psr_query, $builder->getQuery());
    }

    public function testWith()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $this->assertIsString($builder->getQuery());
        $this->assertSame($this->psr_query, $builder->getQuery());

        $builder->withQuery('foo=bar');

        $this->assertIsString($builder->getQuery());
        $this->assertSame('foo=bar', $builder->getQuery());
    }

    public function testArray()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $this->assertIsString($builder->getQuery());
        $this->assertSame($this->psr_query, $builder->getQuery());

        $builder->withQuery(['foo' => 'Foo', 'bar' => 'Bar', 'baz' => ['First', 'Second']]);

        $this->assertIsString($builder->getQuery());
        $this->assertSame('foo=Foo&bar=Bar&baz%5B0%5D=First&baz%5B1%5D=Second', $builder->getQuery());
    }

    public function testEmpty()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $builder->withQuery('');

        $this->assertIsString($builder->getQuery());
        $this->assertEmpty($builder->getQuery());
    }

    public function testNull()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $builder->withQuery(null);

        $this->assertIsString($builder->getQuery());
        $this->assertEmpty($builder->getQuery());
    }
}
