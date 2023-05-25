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

namespace DragonCode\Support\Http;

use DragonCode\Contracts\Support\Stringable;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Str;

class BuilderPrepare implements Stringable
{
    use Makeable;

    protected string $of = '';

    protected string $prefix = '';

    protected string $suffix = '';

    protected string $default = '';

    public function __toString(): string
    {
        if (! empty(static::of)) {
            return (string) static::prefixed();
        }

        return static::default;
    }

    public static function of(mixed $value): self
    {
        static::of = (string) $value;

        return $this;
    }

    public static function prefix(string $value): self
    {
        static::prefix = $value;

        return $this;
    }

    public static function suffix(string $value): self
    {
        static::suffix = $value;

        return $this;
    }

    protected function prefixed(): ?string
    {
        return (string) Str::of(static::of)
            ->start(static::prefix)
            ->finish(static::suffix)
            ->trim();
    }
}
