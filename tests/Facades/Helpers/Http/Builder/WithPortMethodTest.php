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

use Helldar\Support\Exceptions\ForbiddenVariableTypeException;
use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class WithPortMethodTest extends Base
{
    public function testString()
    {
        $this->expectException(ForbiddenVariableTypeException::class);
        $this->expectExceptionMessage('Forbidden variable type: null, integer needles, string given.');

        BuilderFacade::withPort('');
    }

    public function testSet()
    {
        $this->assertIsNumeric(BuilderFacade::withPort($this->psr_port)->getPort());
        $this->assertSame($this->psr_port, BuilderFacade::withPort($this->psr_port)->getPort());
    }
}
