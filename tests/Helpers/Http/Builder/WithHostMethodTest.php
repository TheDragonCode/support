<?php
/******************************************************************************
 * This file is part of the "andrey-helldar/support" project.                 *
 *                                                                            *
 * @author Andrey Helldar <helldar@ai-rus.com>                                *
 *                                                                            *
 * @copyright 2021 Andrey Helldar                                             *
 *                                                                            *
 * @license MIT                                                               *
 *                                                                            *
 * @see https://github.com/andrey-helldar/support                             *
 *                                                                            *
 * For the full copyright and license information, please view the LICENSE    *
 * file that was distributed with this source code.                           *
 ******************************************************************************/

namespace Tests\Helpers\Http\Builder;

use Tests\Helpers\Http\Base;

class WithHostMethodTest extends Base
{
    public function testSet()
    {
        $builder = $this->builder();

        $this->assertIsString($builder->getHost());
        $this->assertEmpty($builder->getHost());

        $builder->withHost('example.com');

        $this->assertIsString($builder->getHost());
        $this->assertSame('example.com', $builder->getHost());
    }

    public function testReplace()
    {
        $builder = $this->builder()->parse($this->test_url);

        $this->assertIsString($builder->getHost());
        $this->assertSame($this->psr_host, $builder->getHost());

        $builder->withHost('example.com');

        $this->assertIsString($builder->getHost());
        $this->assertSame('example.com', $builder->getHost());
    }

    public function testEmpty()
    {
        $builder = $this->builder()->parse($this->test_url);

        $builder->withHost('');

        $this->assertIsString($builder->getHost());
        $this->assertEmpty($builder->getHost());
    }

    public function testNull()
    {
        $builder = $this->builder()->parse($this->test_url);

        $builder->withHost(null);

        $this->assertIsString($builder->getHost());
        $this->assertEmpty($builder->getHost());
    }
}
