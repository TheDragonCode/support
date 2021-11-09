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

namespace Tests\Facades\Helpers\Http\Builder;

use DragonCode\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class GetUserInfoMethodTest extends Base
{
    public function testWith()
    {
        $builder = BuilderFacade::parse($this->psr_url);

        $this->assertIsString($builder->getUserInfo());
        $this->assertSame($this->psr_user . ':' . $this->psr_pass, $builder->getUserInfo());
    }

    public function testWithout()
    {
        $builder = BuilderFacade::parse($this->test_url);

        $this->assertIsString($builder->getUserInfo());
        $this->assertEmpty($builder->getUserInfo());
    }

    public function testOnlyUser()
    {
        $builder = BuilderFacade::parse('https://foo@example.com');

        $this->assertIsString($builder->getUserInfo());
        $this->assertSame($this->psr_user, $builder->getUserInfo());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::getUserInfo());
        $this->assertEmpty(BuilderFacade::getUserInfo());
    }
}
