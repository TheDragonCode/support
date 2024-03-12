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

namespace Tests\Fixtures\Instances;

use Tests\Fixtures\Concerns\Foable;
use Tests\Fixtures\Contracts\Contract;

class Foo implements Contract
{
    use Foable;

    public const FOO = 'Foo';
    public const BAR = 'Bar';
    public const BAZ = 'Baz';

    public static function callStatic(): string
    {
        return 'ok';
    }

    public function callDymamic(): string
    {
        return 'ok';
    }

    public function callEmpty(): bool
    {
        return false;
    }

    public function callParameter(string $value): string
    {
        return 'foo_' . $value;
    }
}
