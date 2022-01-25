<?php

declare(strict_types=1);

namespace DragonCode\Support\Concerns;

trait Dumpable
{
    /**
     * Outputs the contents of a variable without terminating the application.
     *
     * @return $this
     */
    public function dump(): self
    {
        dump($this->value);

        return $this;
    }

    /**
     * Outputs the contents of a variable, terminating the application.
     */
    public function dd(): void
    {
        dd($this->value);
    }
}
