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

namespace Tests\Helpers\Http\Builder;

use Tests\Helpers\Http\Base;

class RemoveQueryMethodTest extends Base
{
    public function testWith()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $this->assertIsString($builder->getQuery());
        $this->assertSame($this->psr_query, $builder->getQuery());

        $builder->putQuery('foo', 'Foo');
        $builder->putQuery('bar', 'Bar');
        $builder->putQuery('baz', ['First', 'Second']);

        $this->assertIsString($builder->getQuery());
        $this->assertSame('id=123&name=hey&foo=Foo&bar=Bar&baz%5B0%5D=First&baz%5B1%5D=Second', $builder->getQuery());

        $builder->removeQuery('foo');

        $this->assertIsString($builder->getQuery());
        $this->assertSame('id=123&name=hey&bar=Bar&baz%5B0%5D=First&baz%5B1%5D=Second', $builder->getQuery());

        $builder->removeQuery('baz');

        $this->assertIsString($builder->getQuery());
        $this->assertSame('id=123&name=hey&bar=Bar', $builder->getQuery());
    }

    public function testWithout()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsString($builder->getQuery());
        $this->assertEmpty($builder->getQuery());

        $builder->putQuery('foo', 'Foo');
        $builder->putQuery('bar', 'Bar');
        $builder->putQuery('baz', ['First', 'Second']);

        $this->assertIsString($builder->getQuery());
        $this->assertSame('foo=Foo&bar=Bar&baz%5B0%5D=First&baz%5B1%5D=Second', $builder->getQuery());

        $builder->removeQuery('baz');

        $this->assertIsString($builder->getQuery());
        $this->assertSame('foo=Foo&bar=Bar', $builder->getQuery());
    }

    public function testEmpty()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsString($builder->getQuery());
        $this->assertEmpty($builder->getQuery());

        $builder->removeQuery('foo');

        $this->assertIsString($builder->getQuery());
        $this->assertEmpty($builder->getQuery());
    }
}
