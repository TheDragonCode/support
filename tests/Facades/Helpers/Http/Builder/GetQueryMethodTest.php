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

class GetQueryMethodTest extends Base
{
    public function testWith()
    {
        $builder = BuilderFacade::parse($this->psr_url);

        $this->assertIsString($builder->getQuery());
        $this->assertSame($this->psr_query, $builder->getQuery());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::getQuery());
        $this->assertEmpty(BuilderFacade::getQuery());
    }
}
