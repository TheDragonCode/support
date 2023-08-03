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

class ToUrlMethodTest extends Base
{
    public function testShort()
    {
        $builder = Builder::parse($this->test_url);

        $this->assertIsString($builder->toUrl());

        $this->assertSame(rtrim($this->test_url, '/'), $builder->toUrl());
    }

    public function testFull()
    {
        $builder = Builder::parse($this->psr_url);

        $this->assertIsString($builder->toUrl());

        $this->assertSame($this->psr_url, $builder->toUrl());
    }

    public function testEmpty()
    {
        $builder = Builder::same();

        $this->assertIsString($builder->toUrl());

        $this->assertSame('', $builder->toUrl());
    }
}
