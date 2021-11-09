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

namespace Tests\Facades\Helpers\Http\Builder;

use DragonCode\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class WithQueryMethodTest extends Base
{
    public function testSet()
    {
        $this->assertIsString(BuilderFacade::withQuery($this->psr_query)->getQuery());
        $this->assertSame($this->psr_query, BuilderFacade::withQuery($this->psr_query)->getQuery());
    }

    public function testArray()
    {
        $array = ['foo' => 'Foo', 'bar' => 'Bar', 'baz' => ['First', 'Second']];

        $this->assertIsString(BuilderFacade::withQuery($array)->getQuery());
        $this->assertSame('foo=Foo&bar=Bar&baz%5B0%5D=First&baz%5B1%5D=Second', BuilderFacade::withQuery($array)->getQuery());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::withQuery('')->getQuery());
        $this->assertEmpty(BuilderFacade::withQuery('')->getQuery());
    }

    public function testNull()
    {
        $this->assertIsString(BuilderFacade::withQuery(null)->getQuery());
        $this->assertEmpty(BuilderFacade::withQuery(null)->getQuery());
    }
}
