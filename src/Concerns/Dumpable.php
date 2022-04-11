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

namespace DragonCode\Support\Concerns;

use JetBrains\PhpStorm\NoReturn;

trait Dumpable
{
    /**
     * Outputs the contents of a variable without terminating the application.
     *
     * @return $this
     */
    public function dump(): static
    {
        dump($this->value);

        return $this;
    }

    /**
     * Outputs the contents of a variable, terminating the application.
     *
     * @return void
     */
    #[NoReturn]
    public function dd(): void
    {
        dd($this->value);
    }
}
