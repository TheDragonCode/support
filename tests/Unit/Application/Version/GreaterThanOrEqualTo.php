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

class GreaterThanOrEqualTo extends Base
{
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
}
