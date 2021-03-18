<?php

namespace Helldar\Support\Concerns;

/**
 * If you use this trait, you need to install the dependency:.
 *
 * composer require symfony/deprecation-contracts
 */
trait Deprecation
{
    protected static $next_version = '4.0';

    protected static function deprecatedMethod(string $old_method, string $new_class, string $new_method): void
    {
        $namespace = static::getDeprecatedNamespace();

        static::deprecated(
            'The %s::%s() method has been deprecated and will be removed in version %s, use  %s::%s() instead.',
            $namespace,
            $old_method,
            static::$next_version,
            $new_class,
            $new_method
        );
    }

    protected static function getDeprecatedNamespace(): string
    {
        return static::class;
    }

    protected static function deprecated(string $message, ...$args): void
    {
        trigger_deprecation('andrey-helldar/support', static::$next_version, $message, ...$args);
    }
}
