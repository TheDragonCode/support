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

declare(strict_types=1);

namespace Tests\Unit\Instances\Helpers\Http\Builder;

use DragonCode\Support\Facades\Http\Builder;
use Tests\Unit\Instances\Helpers\Http\Base;

class GetDomainLevelMethodTest extends Base
{
    public function testShort()
    {
        $builder = Builder::parse($this->test_url);

        $this->assertSame('com', $builder->getDomainLevel(1));
        $this->assertSame('example', $builder->getDomainLevel(2));
        $this->assertSame('en', $builder->getDomainLevel(3));

        $this->assertEmpty($builder->getDomainLevel());
        $this->assertEmpty($builder->getDomainLevel(4));

        $this->assertIsString($builder->getDomainLevel());
        $this->assertIsString($builder->getDomainLevel(4));
    }

    public function testFull()
    {
        $builder = Builder::parse($this->psr_url);

        $this->assertSame('com', $builder->getDomainLevel(1));
        $this->assertSame('example', $builder->getDomainLevel(2));
        $this->assertSame('en', $builder->getDomainLevel(3));

        $this->assertEmpty($builder->getDomainLevel());
        $this->assertEmpty($builder->getDomainLevel(4));

        $this->assertIsString($builder->getDomainLevel());
        $this->assertIsString($builder->getDomainLevel(4));
    }

    public function testEmpty()
    {
        $this->assertEmpty(Builder::getDomainLevel());
        $this->assertEmpty(Builder::getDomainLevel(4));

        $this->assertIsString(Builder::getDomainLevel());
        $this->assertIsString(Builder::getDomainLevel(4));
    }
}
