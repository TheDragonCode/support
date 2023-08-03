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

class PutQueryMethodTest extends Base
{
    public function testWith()
    {
        $builder = Builder::parse($this->psr_url);

        $this->assertIsString($builder->getQuery());
        $this->assertSame($this->psr_query, $builder->getQuery());

        $builder->putQuery('foo', 'Foo');
        $builder->putQuery('bar', 'Bar');
        $builder->putQuery('baz', ['First', 'Second']);

        $this->assertIsString($builder->getQuery());
        $this->assertSame('id=123&name=hey&foo=Foo&bar=Bar&baz%5B0%5D=First&baz%5B1%5D=Second', $builder->getQuery());
    }

    public function testWithout()
    {
        $builder = Builder::parse($this->test_url);

        $this->assertIsString($builder->getQuery());
        $this->assertEmpty($builder->getQuery());

        $builder->putQuery('foo', 'Foo');
        $builder->putQuery('bar', 'Bar');
        $builder->putQuery('baz', ['First', 'Second']);

        $this->assertIsString($builder->getQuery());
        $this->assertSame('foo=Foo&bar=Bar&baz%5B0%5D=First&baz%5B1%5D=Second', $builder->getQuery());
    }

    public function testEmpty()
    {
        $builder = Builder::parse($this->test_url);

        $this->assertIsString($builder->getQuery());
        $this->assertEmpty($builder->getQuery());

        $builder->putQuery('foo', '');

        $this->assertIsString($builder->getQuery());
        $this->assertSame('', $builder->getQuery());
    }

    public function testNull()
    {
        $builder = Builder::parse($this->test_url);

        $this->assertIsString($builder->getQuery());
        $this->assertEmpty($builder->getQuery());

        $builder->putQuery('foo', null);

        $this->assertIsString($builder->getQuery());
        $this->assertSame('', $builder->getQuery());
    }
}
