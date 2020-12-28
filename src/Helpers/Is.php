<?php

namespace Helldar\Support\Helpers;

use Exception;
use Helldar\Support\Facades\Helpers\Instance;
use Helldar\Support\Facades\Helpers\Reflection;
use ReflectionClass;
use Throwable;

final class Is
{
    public function object($value): bool
    {
        return is_object($value);
    }

    public function string($value): bool
    {
        return is_string($value);
    }

    public function contract($value): bool
    {
        $class = Instance::classname($value);

        return Reflection::resolve($value)->isInterface() || interface_exists($class);
    }

    public function error($value): bool
    {
        return Instance::of($value, [Exception::class, Throwable::class]);
    }

    public function reflectionClass($class): bool
    {
        return Instance::of($class, ReflectionClass::class);
    }
}
