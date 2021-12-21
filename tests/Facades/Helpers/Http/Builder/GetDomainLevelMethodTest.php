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

namespace Tests\Facades\Helpers\Http\Builder;

use DragonCode\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class GetDomainLevelMethodTest extends Base
{
    public function testShort()
    {
        $builder = BuilderFacade::parse($this->test_url);

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
        $builder = BuilderFacade::parse($this->psr_url);

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
        $this->assertEmpty(BuilderFacade::getDomainLevel());
        $this->assertEmpty(BuilderFacade::getDomainLevel(4));

        $this->assertIsString(BuilderFacade::getDomainLevel());
        $this->assertIsString(BuilderFacade::getDomainLevel(4));
    }
}
