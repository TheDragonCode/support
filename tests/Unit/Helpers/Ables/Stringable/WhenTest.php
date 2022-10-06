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

namespace Tests\Unit\Helpers\Ables\Stringable;

use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Helpers\Ables\Stringable;
use Tests\TestCase;

class WhenTest extends TestCase
{
    public function testTrue()
    {
        $object = Str::of('qwerty')->when(true, fn ($value) => Str::upper($value));

        $this->assertInstanceOf(Stringable::class, $object);
        $this->assertSame('QWERTY', $object->toString());
    }

    public function testFalse()
    {
        $object = Str::of('qwerty')->when(false, fn ($value) => Str::upper($value));

        $this->assertInstanceOf(Stringable::class, $object);
        $this->assertSame('qwerty', $object->toString());
    }
}
