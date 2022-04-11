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

namespace DragonCode\Support\Application;

class Version
{
    public function __construct(
        protected ?string $version = null
    ) {
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
