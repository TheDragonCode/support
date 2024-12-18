<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2024 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace Tests\Unit\Http\Builder;

use DragonCode\Support\Facades\Http\Builder;

class WithPortMethodTest extends Base
{
    public function testEmpty()
    {
        $builder = Builder::parse($this->test_url);

        $this->assertNull($builder->getPort());

        $builder->withPort($this->psr_port);

        $this->assertIsNumeric($builder->getPort());
        $this->assertSame($this->psr_port, $builder->getPort());
    }

    public function testReplace()
    {
        $builder = Builder::parse($this->psr_url);

        $this->assertIsNumeric($builder->getPort());
        $this->assertSame($this->psr_port, $builder->getPort());

        $builder->withPort(1234);

        $this->assertIsNumeric($builder->getPort());
        $this->assertSame(1234, $builder->getPort());
    }
}
