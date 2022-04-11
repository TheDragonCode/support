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

declare(strict_types=1);

namespace Tests\Unit\Types\Is;

use DragonCode\Support\Facades\Types\Is;
use Tests\Fixtures\Contracts\Contract;
use Tests\Fixtures\Instances\Bar;
use Tests\Fixtures\Instances\Baz;
use Tests\Fixtures\Instances\Foo;
use Tests\TestCase;

class ContractTest extends TestCase
{
    public function testContract()
    {
        $this->assertTrue(Is::contract(Contract::class));

        $this->assertFalse(Is::contract(Foo::class));
        $this->assertFalse(Is::contract(Bar::class));
        $this->assertFalse(Is::contract(Baz::class));

        $this->assertFalse(Is::contract(new Foo()));
        $this->assertFalse(Is::contract(new Bar()));
        $this->assertFalse(Is::contract(new Baz()));

        $this->assertFalse(Is::contract('foo'));
    }
}
