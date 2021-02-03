<?php

namespace Helldar\Support\Concerns;

trait Deprecation
{
    protected static function deprecatedMethod(string $old_method, string $new_class, string $new_method): void
    {
        $namespace = static::getDeprecatedNamespace();

        static::deprecated(
            'The %s::%s() method has been deprecated and will be removed in version 3.0, use  %s::%s() instead.',
            $namespace,
            $old_method,
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
        trigger_deprecation('andrey-helldar/support', '3.0', $message, ...$args);
    }
}
