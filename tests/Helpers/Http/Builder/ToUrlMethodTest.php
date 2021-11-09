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

class ToUrlMethodTest extends Base
{
    public function testShort()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsString($builder->toUrl());

        $this->assertSame(rtrim($this->test_url, '/'), $builder->toUrl());
    }

    public function testFull()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $this->assertIsString($builder->toUrl());

        $this->assertSame($this->psr_url, $builder->toUrl());
    }

    public function testEmpty()
    {
        $builder = $this->builder();

        $this->assertIsString($builder->toUrl());

        $this->assertSame('', $builder->toUrl());
    }
}
