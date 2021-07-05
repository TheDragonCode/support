<?php

namespace Helldar\Support\Tools;

use Helldar\Support\Concerns\Makeable;

class HttpBuilderPrepare
{
    use Makeable;

    protected $of;

    protected $prefix = '';

    protected $suffix = '';

    protected $default = '';

    public function of(?string $value): self
    {
        $this->of = $value;

        return $this;
    }

    public function prefix(string $value): self
    {
        $this->prefix = $value;

        return $this;
    }

    public function suffix(string $value): self
    {
        $this->suffix = $value;

        return $this;
    }

    public function get(): ?string
    {
        if (! empty($this->of)) {
            return $this->prefexible();
        }

        return $this->default;
    }

    protected function getValue(): ?string
    {
        $characters = " \t\n\r\0\x0B" . $this->prefix . $this->suffix;

        return ! empty($this->of) ? trim($this->of, $characters) : null;
    }

    protected function prefexible(): ?string
    {
        return $this->prefix . $this->getValue() . $this->suffix;
    }
}
