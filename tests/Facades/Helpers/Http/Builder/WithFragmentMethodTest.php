<?php
/*
 * This file is part of the "andrey-helldar/support" project.
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
 * @see https://github.com/andrey-helldar/support
 */

namespace Tests\Facades\Helpers\Http\Builder;

use DragonCode\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class WithFragmentMethodTest extends Base
{
    public function testSet()
    {
        $this->assertIsString(BuilderFacade::withFragment($this->psr_fragment)->getFragment());
        $this->assertSame($this->psr_fragment, BuilderFacade::withFragment($this->psr_fragment)->getFragment());
    }
}
