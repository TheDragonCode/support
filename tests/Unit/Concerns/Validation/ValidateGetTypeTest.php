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

namespace Tests\Unit\Concerns\Validation;

use DragonCode\Support\Concerns\Validation;
use Tests\TestCase;

class ValidateGetTypeTest extends TestCase
{
    use Validation;

    public function testValidate()
    {
        $this->assertSame('string', $this->validateGetType(static::class));

        $this->assertSame('object', $this->validateGetType($this));
    }
}
