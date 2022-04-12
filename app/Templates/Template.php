<?php

namespace DragonCode\SupportDev\Templates;

use DragonCode\Contracts\Support\Stringable;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Str;

/**
 * @method static Template make(string $method, string $description)
 */
abstract class Template implements Stringable
{
    use Makeable;

    protected int $header_level = 0;

    public function __construct(
        protected string $header,
        protected string $content
    ) {
    }

    public function __toString(): string
    {
        return implode(PHP_EOL, [
            $this->getMethodName(),
            '',
            '',
            $this->getContent(),
            '',
            '',
        ]);
    }

    protected function getMethodName(): string
    {
        return Str::of($this->header)
            ->prepend(' ')
            ->prepend(str_pad('', $this->header_level, '#'))
            ->trim();
    }

    protected function getContent(): string
    {
        return Str::of($this->content)->trim();
    }
}
