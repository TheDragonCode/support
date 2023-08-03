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

namespace Tests\Unit\Helpers\Digit;

use DragonCode\Support\Facades\Helpers\Digit;
use Tests\TestCase;

class RoundedTest extends TestCase
{
    public function testRounded()
    {
        $this->assertSame(410000.0, Digit::rounded(4100, 2));
        $this->assertSame(499000.0, Digit::rounded(4990, 2));
        $this->assertSame(98900.0, Digit::rounded(989, 2));
        $this->assertSame(98900.0, Digit::rounded(989, 2));

        $this->assertSame(6100.0, Digit::rounded(6100));
        $this->assertSame(7990.0, Digit::rounded(7990));
        $this->assertSame(289.0, Digit::rounded(289));
    }
}
