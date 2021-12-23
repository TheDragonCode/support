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

class GetSubdomainMethodTest extends Base
{
    public function testShort()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsString($builder->getSubDomain());
        $this->assertSame('en', $builder->getSubDomain());
    }

    public function testFull()
    {
        $builder = $this->builder()->parse($this->psr_url);

        $this->assertIsString($builder->getSubDomain());
        $this->assertSame('en', $builder->getSubDomain());
    }

    public function testEmpty()
    {
        $builder = $this->builder();

        $this->assertIsString($builder->getSubDomain());
        $this->assertEmpty($builder->getSubDomain());
    }
}
