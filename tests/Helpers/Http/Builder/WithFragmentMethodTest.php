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

class WithFragmentMethodTest extends Base
{
    public function testEmpty()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsString($builder->getFragment());
        $this->assertEmpty($builder->getFragment());

        $builder->withFragment($this->psr_fragment);

        $this->assertIsString($builder->getFragment());
        $this->assertSame($this->psr_fragment, $builder->getFragment());
    }

    public function testReplace()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsString($builder->getFragment());
        $this->assertEmpty($builder->getFragment());

        $builder->withFragment($this->psr_fragment);

        $this->assertIsString($builder->getFragment());
        $this->assertSame($this->psr_fragment, $builder->getFragment());

        $builder->withFragment('foo');

        $this->assertIsString($builder->getFragment());
        $this->assertSame('foo', $builder->getFragment());
    }
}
