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

class FactorialTest extends TestCase
{
    public function testFactorial()
    {
        $this->assertSame(1, Digit::factorial(1));
        $this->assertSame(2, Digit::factorial(2));
        $this->assertSame(120, Digit::factorial(5));
        $this->assertSame(40320, Digit::factorial(8));
        $this->assertSame(3628800, Digit::factorial(10));
    }
}
