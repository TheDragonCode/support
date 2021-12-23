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

namespace Tests\Unit\Helpers\Http\Builder;

use Tests\Unit\Helpers\Http\Base;

class GetDomainLevelMethodTest extends Base
{
    public function testShort()
    {
        $builder = $this->builder()->parse($this->test_url);

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
        $builder = $this->builder()->parse($this->psr_url);

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
        $this->assertEmpty($this->builder()->getDomainLevel());
        $this->assertEmpty($this->builder()->getDomainLevel(4));

        $this->assertIsString($this->builder()->getDomainLevel());
        $this->assertIsString($this->builder()->getDomainLevel(4));
    }
}
