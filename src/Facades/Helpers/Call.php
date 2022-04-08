<?php
/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Facades\Helpers;

use DragonCode\Support\Facades\Facade;
use DragonCode\Support\Helpers\Call as Helper;

/**
 * @method static mixed|null run(mixed $class, string $method, ...$parameters)
 * @method static mixed|null runExists(mixed $class, string $method, ...$parameters)
 * @method static mixed|null runMethods($class, $methods, ...$parameters)
 * @method static mixed|null runOf(array $map, $value, ...$parameters)
 * @method static mixed|null when(bool $when, mixed $class, string $method, ...$parameters)
 */
class Call extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Helper::class;
    }
}
