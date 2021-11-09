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

class WithSchemeMethodTest extends Base
{
    public function testSet()
    {
        $this->assertIsString(BuilderFacade::withScheme($this->psr_scheme)->getScheme());
        $this->assertSame($this->psr_scheme, BuilderFacade::withScheme($this->psr_scheme)->getScheme());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::withScheme('')->getScheme());
        $this->assertEmpty(BuilderFacade::withScheme('')->getScheme());
    }

    public function testNull()
    {
        $this->assertIsString(BuilderFacade::withScheme(null)->getScheme());
        $this->assertEmpty(BuilderFacade::withScheme(null)->getScheme());
    }
}
