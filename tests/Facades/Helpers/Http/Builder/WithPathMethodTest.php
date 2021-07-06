<?php
/******************************************************************************
 * This file is part of the "andrey-helldar/support" project.                 *
 *                                                                            *
 * @author Andrey Helldar <helldar@ai-rus.com>                                *
 *                                                                            *
 * @copyright 2021 Andrey Helldar                                             *
 *                                                                            *
 * @license MIT                                                               *
 *                                                                            *
 * @see https://github.com/andrey-helldar/support                             *
 *                                                                            *
 * For the full copyright and license information, please view the LICENSE    *
 * file that was distributed with this source code.                           *
 ******************************************************************************/

namespace Tests\Facades\Helpers\Http\Builder;

use Helldar\Support\Facades\Http\Builder as BuilderFacade;
use Tests\Facades\Helpers\Http\Base;

class WithPathMethodTest extends Base
{
    public function testWithoutPrefix()
    {
        $this->assertIsString(BuilderFacade::withPath('foo/bar')->getPath());
        $this->assertSame('/foo/bar', BuilderFacade::withPath('foo/bar')->getPath());
    }

    public function testWithPrefix()
    {
        $this->assertIsString(BuilderFacade::withPath('/foo/bar')->getPath());
        $this->assertSame('/foo/bar', BuilderFacade::withPath('/foo/bar')->getPath());
    }

    public function testEmpty()
    {
        $this->assertIsString(BuilderFacade::withPath('')->getPath());
        $this->assertSame('', BuilderFacade::withPath('')->getPath());
    }

    public function testNull()
    {
        $this->assertIsString(BuilderFacade::withPath(null)->getPath());
        $this->assertSame('', BuilderFacade::withPath(null)->getPath());
    }
}
