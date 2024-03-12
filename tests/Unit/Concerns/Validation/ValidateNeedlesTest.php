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

namespace Tests\Unit\Concerns\Validation;

use DragonCode\Support\Concerns\Validation;
use Tests\TestCase;

class ValidateNeedlesTest extends TestCase
{
    use Validation;

    public function testValidate()
    {
        $source = [
            'FOO',
            'BaR',
            'BAm',
            'qwerty',
        ];

        $expected = [
            'foo',
            'bar',
            'bam',
            'qwerty',
        ];

        $this->assertSame($expected, $this->validateNeedles($source));
    }
}
