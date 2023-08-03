<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2023 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Application\Version;

class LtTest extends Base
{
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
}
