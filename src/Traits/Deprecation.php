<?php

namespace Helldar\Support\Traits;

use Helldar\Support\Facades\Instance;

trait Deprecation
{
    protected static function deprecationNamespace(string $message = null, ...$args): void
    {
        static::deprecation(
            'The namespace will be changed from %s to \Helldar\Support\Facades\Helpers\%s.',
            static::getDeprecationClassBasename(),
            static::getDeprecationClassBasename()
        );

        if (! empty($message)) {
            static::deprecation($message, ...$args);
        }
    }

    protected static function deprecatedClass(): void
    {
        static::deprecation('The %s class has been deprecated and will be removed.', static::getDeprecationNamespace());
    }

    protected static function getDeprecationNamespace(): string
    {
        return static::class;
    }

    protected static function getDeprecationClassBasename(): string
    {
        return Instance::basename(
            static::getDeprecationNamespace()
        );
    }

    protected static function deprecation(string $message, ...$args): void
    {
        trigger_deprecation('andrey-helldar/support', '2.0', $message, ...$args);
    }
}
