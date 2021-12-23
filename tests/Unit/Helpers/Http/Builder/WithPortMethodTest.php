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

namespace Tests\Unit\Helpers\Http\Builder;

use Tests\Unit\Helpers\Http\Base;

class WithPortMethodTest extends Base
{
    public function testEmpty()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertNull($builder->getPort());

        $builder->withPort($this->psr_port);

        $this->assertIsNumeric($builder->getPort());
        $this->assertSame($this->psr_port, $builder->getPort());
    }

    public function testReplace()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $this->assertIsNumeric($builder->getPort());
        $this->assertSame($this->psr_port, $builder->getPort());

        $builder->withPort(1234);

        $this->assertIsNumeric($builder->getPort());
        $this->assertSame(1234, $builder->getPort());
    }
}
