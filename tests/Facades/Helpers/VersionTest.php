<?php

declare(strict_types=1);

namespace Tests\Facades\Helpers;

use DragonCode\Support\Facades\Helpers\Version as VersionFacade;
use DragonCode\Support\Helpers\Version;
use Tests\TestCase;

class VersionTest extends TestCase
{
    protected $version = '4.5.6';

    public function testLt()
    {
        $this->assertTrue($this->version()->lt('0.0.0'));
        $this->assertTrue($this->version()->lt('1.2.3'));
        $this->assertTrue($this->version()->lt('2.3.4'));
        $this->assertTrue($this->version()->lt('3.4.5'));
        $this->assertTrue($this->version()->lt('4.5.5'));

        $this->assertFalse($this->version()->lt('4.5.6'));
        $this->assertFalse($this->version()->lt('4.5.7'));
        $this->assertFalse($this->version()->lt('4.6.7'));
        $this->assertFalse($this->version()->lt('5.6.7'));
    }

    public function testLessThan()
    {
        $this->assertTrue($this->version()->lessThan('0.0.0'));
        $this->assertTrue($this->version()->lessThan('1.2.3'));
        $this->assertTrue($this->version()->lessThan('2.3.4'));
        $this->assertTrue($this->version()->lessThan('3.4.5'));
        $this->assertTrue($this->version()->lessThan('4.5.5'));

        $this->assertFalse($this->version()->lessThan('4.5.6'));
        $this->assertFalse($this->version()->lessThan('4.5.7'));
        $this->assertFalse($this->version()->lessThan('4.6.7'));
        $this->assertFalse($this->version()->lessThan('5.6.7'));
    }

    public function testLte()
    {
        $this->assertTrue($this->version()->lte('0.0.0'));
        $this->assertTrue($this->version()->lte('1.2.3'));
        $this->assertTrue($this->version()->lte('2.3.4'));
        $this->assertTrue($this->version()->lte('3.4.5'));
        $this->assertTrue($this->version()->lte('4.5.5'));
        $this->assertTrue($this->version()->lte('4.5.6'));

        $this->assertFalse($this->version()->lte('4.5.7'));
        $this->assertFalse($this->version()->lte('4.6.7'));
        $this->assertFalse($this->version()->lte('5.6.7'));
    }

    public function testLessThanOrEqualTo()
    {
        $this->assertTrue($this->version()->lessThanOrEqualTo('0.0.0'));
        $this->assertTrue($this->version()->lessThanOrEqualTo('1.2.3'));
        $this->assertTrue($this->version()->lessThanOrEqualTo('2.3.4'));
        $this->assertTrue($this->version()->lessThanOrEqualTo('3.4.5'));
        $this->assertTrue($this->version()->lessThanOrEqualTo('4.5.5'));
        $this->assertTrue($this->version()->lessThanOrEqualTo('4.5.6'));

        $this->assertFalse($this->version()->lessThanOrEqualTo('4.5.7'));
        $this->assertFalse($this->version()->lessThanOrEqualTo('4.6.7'));
        $this->assertFalse($this->version()->lessThanOrEqualTo('5.6.7'));
    }

    public function testGt()
    {
        $this->assertFalse($this->version()->gt('0.0.0'));
        $this->assertFalse($this->version()->gt('1.2.3'));
        $this->assertFalse($this->version()->gt('2.3.4'));
        $this->assertFalse($this->version()->gt('3.4.5'));
        $this->assertFalse($this->version()->gt('4.5.5'));
        $this->assertFalse($this->version()->gt('4.5.6'));

        $this->assertTrue($this->version()->gt('4.5.7'));
        $this->assertTrue($this->version()->gt('4.6.7'));
        $this->assertTrue($this->version()->gt('5.6.7'));
    }

    public function testGreaterThan()
    {
        $this->assertFalse($this->version()->greaterThan('0.0.0'));
        $this->assertFalse($this->version()->greaterThan('1.2.3'));
        $this->assertFalse($this->version()->greaterThan('2.3.4'));
        $this->assertFalse($this->version()->greaterThan('3.4.5'));
        $this->assertFalse($this->version()->greaterThan('4.5.5'));
        $this->assertFalse($this->version()->greaterThan('4.5.6'));

        $this->assertTrue($this->version()->greaterThan('4.5.7'));
        $this->assertTrue($this->version()->greaterThan('4.6.7'));
        $this->assertTrue($this->version()->greaterThan('5.6.7'));
    }

    public function testGte()
    {
        $this->assertFalse($this->version()->gte('0.0.0'));
        $this->assertFalse($this->version()->gte('1.2.3'));
        $this->assertFalse($this->version()->gte('2.3.4'));
        $this->assertFalse($this->version()->gte('3.4.5'));
        $this->assertFalse($this->version()->gte('4.5.5'));

        $this->assertTrue($this->version()->gte('4.5.6'));
        $this->assertTrue($this->version()->gte('4.5.7'));
        $this->assertTrue($this->version()->gte('4.6.7'));
        $this->assertTrue($this->version()->gte('5.6.7'));
    }

    public function testGreaterThanOrEqualTo()
    {
        $this->assertFalse($this->version()->greaterThanOrEqualTo('0.0.0'));
        $this->assertFalse($this->version()->greaterThanOrEqualTo('1.2.3'));
        $this->assertFalse($this->version()->greaterThanOrEqualTo('2.3.4'));
        $this->assertFalse($this->version()->greaterThanOrEqualTo('3.4.5'));
        $this->assertFalse($this->version()->greaterThanOrEqualTo('4.5.5'));

        $this->assertTrue($this->version()->greaterThanOrEqualTo('4.5.6'));
        $this->assertTrue($this->version()->greaterThanOrEqualTo('4.5.7'));
        $this->assertTrue($this->version()->greaterThanOrEqualTo('4.6.7'));
        $this->assertTrue($this->version()->greaterThanOrEqualTo('5.6.7'));
    }

    public function testEq()
    {
        $this->assertFalse($this->version()->eq('0.0.0'));
        $this->assertFalse($this->version()->eq('1.2.3'));
        $this->assertFalse($this->version()->eq('2.3.4'));
        $this->assertFalse($this->version()->eq('3.4.5'));
        $this->assertFalse($this->version()->eq('4.5.5'));

        $this->assertTrue($this->version()->eq('4.5.6'));

        $this->assertFalse($this->version()->eq('4.5.7'));
        $this->assertFalse($this->version()->eq('4.6.7'));
        $this->assertFalse($this->version()->eq('5.6.7'));
    }

    public function testEqualTo()
    {
        $this->assertFalse($this->version()->equalTo('0.0.0'));
        $this->assertFalse($this->version()->equalTo('1.2.3'));
        $this->assertFalse($this->version()->equalTo('2.3.4'));
        $this->assertFalse($this->version()->equalTo('3.4.5'));
        $this->assertFalse($this->version()->equalTo('4.5.5'));

        $this->assertTrue($this->version()->equalTo('4.5.6'));

        $this->assertFalse($this->version()->equalTo('4.5.7'));
        $this->assertFalse($this->version()->equalTo('4.6.7'));
        $this->assertFalse($this->version()->equalTo('5.6.7'));
    }

    public function testNe()
    {
        $this->assertTrue($this->version()->ne('0.0.0'));
        $this->assertTrue($this->version()->ne('1.2.3'));
        $this->assertTrue($this->version()->ne('2.3.4'));
        $this->assertTrue($this->version()->ne('3.4.5'));
        $this->assertTrue($this->version()->ne('4.5.5'));

        $this->assertFalse($this->version()->ne('4.5.6'));

        $this->assertTrue($this->version()->ne('4.5.7'));
        $this->assertTrue($this->version()->ne('4.6.7'));
        $this->assertTrue($this->version()->ne('5.6.7'));
    }

    public function testNotEqualTo()
    {
        $this->assertTrue($this->version()->notEqualTo('0.0.0'));
        $this->assertTrue($this->version()->notEqualTo('1.2.3'));
        $this->assertTrue($this->version()->notEqualTo('2.3.4'));
        $this->assertTrue($this->version()->notEqualTo('3.4.5'));
        $this->assertTrue($this->version()->notEqualTo('4.5.5'));

        $this->assertFalse($this->version()->notEqualTo('4.5.6'));

        $this->assertTrue($this->version()->notEqualTo('4.5.7'));
        $this->assertTrue($this->version()->notEqualTo('4.6.7'));
        $this->assertTrue($this->version()->notEqualTo('5.6.7'));
    }

    protected function version(): Version
    {
        return VersionFacade::of($this->version);
    }
}
