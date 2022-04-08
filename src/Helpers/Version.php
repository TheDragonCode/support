<?php

declare(strict_types=1);

namespace DragonCode\Support\Helpers;

class Version
{
    protected $version;

    public function __construct(?string $version = null)
    {
        $this->version = $version;
    }

    public function of(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function lt(string $version): bool
    {
        return $this->is($version, 'lt');
    }

    public function lessThan(string $version): bool
    {
        return $this->lt($version);
    }

    public function lte(string $version): bool
    {
        return $this->is($version, 'le');
    }

    public function lessThanOrEqualTo(string $version): bool
    {
        return $this->lte($version);
    }

    public function gt(string $version): bool
    {
        return $this->is($version, 'gt');
    }

    public function greaterThan(string $version): bool
    {
        return $this->gt($version);
    }

    public function gte(string $version): bool
    {
        return $this->is($version, 'ge');
    }

    public function greaterThanOrEqualTo(string $version): bool
    {
        return $this->gte($version);
    }

    public function eq(string $version): bool
    {
        return $this->is($version, 'eq');
    }

    public function equalTo(string $version): bool
    {
        return $this->eq($version);
    }

    public function ne(string $version): bool
    {
        return $this->is($version, 'ne');
    }

    public function notEqualTo(string $version): bool
    {
        return $this->ne($version);
    }

    protected function is(string $version, string $comparator): bool
    {
        return version_compare($version, $this->version, $comparator);
    }
}
