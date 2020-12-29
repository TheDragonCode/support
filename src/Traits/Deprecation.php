<?php

namespace Helldar\Support\Traits;

trait Deprecation
{
    protected static function deprecatedNamespace(): void
    {
        static::deprecated(
            'Namespace "%s" is deprecated, use "%s" instead.',
            static::getDeprecatedNamespace(),
            static::getActualNamespace()
        );
    }

    protected static function deprecatedClass(): void
    {
        static::deprecated('The %s class has been deprecated and will be removed.', static::getDeprecatedNamespace());
    }

    protected static function deprecatedRenameMethod(string $old, string $new): void
    {
        static::deprecated('Using "%s()" method is deprecated, use "%s()" instead.', $old, $new);
    }

    protected static function deprecatedMethodParameters(string $method): void
    {
        static::deprecated('The parameters or typisation of the "%s" method will be changed.', $method);
    }

    protected static function getDeprecatedNamespace(): string
    {
        return static::class;
    }

    protected static function getActualNamespace(): string
    {
        $classname = static::getDeprecatedNamespace();
        $basename  = static::getDeprecatedBasename();

        return in_array($basename, ['Directory', 'File'])
            ? str_replace('\\' . $basename, '\\Helpers\\Filesystem\\' . $basename, $classname)
            : str_replace('\\' . $basename, '\\Helpers\\' . $basename, $classname);
    }

    protected static function getDeprecatedBasename(): string
    {
        $class = static::getDeprecatedNamespace();

        return basename(str_replace('\\', '/', $class));
    }

    protected static function deprecated(string $message, ...$args): void
    {
        trigger_deprecation('andrey-helldar/support', '2.0', $message, ...$args);
    }
}
