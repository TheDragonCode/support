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

class GetUserMethodTest extends Base
{
    public function testWith()
    {
        $builder = Builder::parse($this->psr_url);

        $this->assertIsString($builder->getUser());
        $this->assertSame($this->psr_user, $builder->getUser());
    }

    public function testWithout()
    {
        $builder = Builder::parse($this->test_url);

        $this->assertIsString($builder->getUser());
        $this->assertEmpty($builder->getUser());
    }

    public function testOnlyUser()
    {
        $builder = Builder::parse('https://foo@example.com');

        $this->assertIsString($builder->getUser());
        $this->assertSame($this->psr_user, $builder->getUser());
    }
}
