<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2024 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

declare(strict_types=1);

namespace Tests\Unit\Application\Version;

class EqualToTest extends Base
{
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
}
