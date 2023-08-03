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

namespace Tests\Fixtures\Instances;

use DragonCode\Support\Concerns\Makeable;
use Tests\Fixtures\Contracts\Contract;

class Bat implements Contract
{
    use Makeable;

    public function __construct(
        public ?string $foo = null,
        public ?string $bar = null
    ) {}
}
