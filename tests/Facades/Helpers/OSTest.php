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

namespace Tests\Facades\Helpers;

use DragonCode\Support\Facades\Helpers\OS;
use Tests\TestCase;

class OSTest extends TestCase
{
    public function testIsLinux()
    {
        $this->assertTrue(OS::isLinux());
    }

    public function testFamily()
    {
        $this->assertSame('linux', OS::family());
        $this->assertSame('Linux', OS::family(false));
    }

    public function testIsDarwin()
    {
        $this->assertFalse(OS::isDarwin());
    }

    public function testIsWindows()
    {
        $this->assertFalse(OS::isWindows());
    }

    public function testIsBSD()
    {
        $this->assertFalse(OS::isBSD());
    }

    public function testIsUnix()
    {
        $this->assertTrue(OS::isUnix());
    }

    public function testIsUnknown()
    {
        $this->assertFalse(OS::isUnknown());
    }

    public function testIsSolaris()
    {
        $this->assertFalse(OS::isSolaris());
    }
}
