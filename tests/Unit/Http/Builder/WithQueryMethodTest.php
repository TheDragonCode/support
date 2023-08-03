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

class WithQueryMethodTest extends Base
{
    public function testWithout()
    {
        $builder = Builder::same();

        $this->assertIsString($builder->getQuery());
        $this->assertEmpty($builder->getQuery());

        $builder->withQuery($this->psr_query);

        $this->assertIsString($builder->getQuery());
        $this->assertSame($this->psr_query, $builder->getQuery());
    }

    public function testWith()
    {
        $builder = Builder::parse($this->psr_url);

        $this->assertIsString($builder->getQuery());
        $this->assertSame($this->psr_query, $builder->getQuery());

        $builder->withQuery('foo=bar');

        $this->assertIsString($builder->getQuery());
        $this->assertSame('foo=bar', $builder->getQuery());
    }

    public function testArray()
    {
        $builder = Builder::parse($this->psr_url);

        $this->assertIsString($builder->getQuery());
        $this->assertSame($this->psr_query, $builder->getQuery());

        $builder->withQuery(['foo' => 'Foo', 'bar' => 'Bar', 'baz' => ['First', 'Second']]);

        $this->assertIsString($builder->getQuery());
        $this->assertSame('foo=Foo&bar=Bar&baz%5B0%5D=First&baz%5B1%5D=Second', $builder->getQuery());
    }

    public function testEmpty()
    {
        $builder = Builder::parse($this->psr_url);

        $builder->withQuery('');

        $this->assertIsString($builder->getQuery());
        $this->assertEmpty($builder->getQuery());
    }

    public function testNull()
    {
        $builder = Builder::parse($this->psr_url);

        $builder->withQuery(null);

        $this->assertIsString($builder->getQuery());
        $this->assertEmpty($builder->getQuery());
    }
}
