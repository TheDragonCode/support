<?php

namespace Tests;

use Helldar\Support\Helpers\OS;
use PHPUnit\Framework\TestCase;

class OSTest extends TestCase
{
    public function testIsWindows()
    {
        $this->assertFalse(OS::isWindows());
    }

    public function testIsDarwin()
    {
        $this->assertFalse(OS::isDarwin());
    }

    public function testIsSolaris()
    {
        $this->assertFalse(OS::isSolaris());
    }

    public function testIsUnknown()
    {
        $this->assertFalse(OS::isUnknown());
    }

    public function testIsUnix()
    {
        $this->assertTrue(OS::isUnix());
    }

    public function testIsBSD()
    {
        $this->assertFalse(OS::isBSD());
    }

    public function testIsLinux()
    {
        $this->assertTrue(OS::isLinux());
    }
}
