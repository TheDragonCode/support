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

namespace DragonCode\Support\Concerns;

/**
 * If you use this trait, you need to install the dependency:.
 *
 * composer require symfony/deprecation-contracts
 */
trait Deprecation
{
    protected static $next_version = '6.0';

    protected static function deprecatedClass(string $new_class, ?string $old_class = null): void
    {
        $old_class = static::getDeprecatedNamespace($old_class);

        static::deprecated(
            'The %s class has been deprecated and will be removed in version %s, use %s instead.',
            $old_class,
            static::$next_version,
            $new_class
        );
    }

    protected static function deprecatedMethod(string $old_method, string $new_class, ?string $new_method = null): void
    {
        $namespace = static::getDeprecatedNamespace();

        static::deprecated(
            'The %s::%s() method has been deprecated and will be removed in version %s, use  %s::%s() instead.',
            $namespace,
            $old_method,
            static::$next_version,
            $new_class,
            $new_method ?: $old_method
        );
    }

    protected static function getDeprecatedNamespace(?string $old_namespace = null): string
    {
        return $old_namespace ?: static::class;
    }

    protected static function deprecated(string $message, ...$args): void
    {
        trigger_deprecation('dragon-code/support', static::$next_version, $message, ...$args);
    }
}
