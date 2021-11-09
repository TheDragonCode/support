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

namespace Tests\Helpers;

use DragonCode\Support\Helpers\OS;
use Tests\TestCase;

class OSTest extends TestCase
{
    public function testIsLinux()
    {
        $this->assertTrue($this->os()->isLinux());
    }

    public function testFamily()
    {
        $this->assertSame('linux', $this->os()->family());
        $this->assertSame('Linux', $this->os()->family(false));
    }

    public function testIsDarwin()
    {
        $this->assertFalse($this->os()->isDarwin());
    }

    public function testIsWindows()
    {
        $this->assertFalse($this->os()->isWindows());
    }

    public function testIsBSD()
    {
        $this->assertFalse($this->os()->isBSD());
    }

    public function testIsUnix()
    {
        $this->assertTrue($this->os()->isUnix());
    }

    public function testIsUnknown()
    {
        $this->assertFalse($this->os()->isUnknown());
    }

    public function testIsSolaris()
    {
        $this->assertFalse($this->os()->isSolaris());
    }

    protected function os(): OS
    {
        return new OS();
    }
}
