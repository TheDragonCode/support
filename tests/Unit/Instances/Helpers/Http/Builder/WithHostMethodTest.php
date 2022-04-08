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

namespace Tests\Unit\Instances\Helpers\Http\Builder;

use DragonCode\Support\Facades\Http\Builder;
use Tests\Unit\Instances\Helpers\Http\Base;

class WithHostMethodTest extends Base
{
    public function testSet()
    {
        $builder = Builder::same();

        $this->assertIsString($builder->getHost());
        $this->assertEmpty($builder->getHost());

        $builder->withHost('example.com');

        $this->assertIsString($builder->getHost());
        $this->assertSame('example.com', $builder->getHost());
    }

    public function testReplace()
    {
        $builder = Builder::parse($this->test_url);

        $this->assertIsString($builder->getHost());
        $this->assertSame($this->psr_host, $builder->getHost());

        $builder->withHost('example.com');

        $this->assertIsString($builder->getHost());
        $this->assertSame('example.com', $builder->getHost());
    }

    public function testEmpty()
    {
        $builder = Builder::parse($this->test_url);

        $builder->withHost('');

        $this->assertIsString($builder->getHost());
        $this->assertEmpty($builder->getHost());
    }

    public function testNull()
    {
        $builder = Builder::parse($this->test_url);

        $builder->withHost(null);

        $this->assertIsString($builder->getHost());
        $this->assertEmpty($builder->getHost());
    }
}
