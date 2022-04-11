<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Application\Version;

class LessThanTest extends Base
{
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
}
