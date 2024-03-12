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

namespace Tests\Unit\Concerns\Resolvable;

use DragonCode\Support\Facades\Helpers\Str;

class ResolveCallbackTest extends Base
{
    public function testResolveCallback()
    {
        $this->clean();

        $resolved = self::resolveCallback('foo', static fn (string $value) => Str::upper($value));

        $this->assertSame('FOO', $resolved);

        $resolved = self::resolveCallback('foo', static fn () => 123);

        $this->assertSame('FOO', $resolved);
    }
}
