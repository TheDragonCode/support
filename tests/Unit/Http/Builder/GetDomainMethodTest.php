<?php
/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace Tests\Unit\Http\Builder;

use DragonCode\Support\Facades\Http\Builder;

class GetDomainMethodTest extends Base
{
    public function testShort()
    {
        $builder = Builder::parse($this->test_url);

        $this->assertIsString($builder->getDomain());
        $this->assertSame('en.example.com', $builder->getDomain());
    }

    public function testFull()
    {
        $builder = Builder::parse($this->psr_url);

        $this->assertIsString($builder->getDomain());
        $this->assertSame('en.example.com', $builder->getDomain());
    }

    public function testEmpty()
    {
        $builder = Builder::same();

        $this->assertIsString($builder->getDomain());
        $this->assertEmpty($builder->getDomain());
    }
}
