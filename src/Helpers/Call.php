<?php

namespace Helldar\Support\Helpers;

use Closure;
use Helldar\Support\Facades\Helpers\Arr as ArrHelper;
use Helldar\Support\Facades\Helpers\Instance as InstanceHelper;
use Helldar\Support\Facades\Helpers\Is as IsHelper;
use Helldar\Support\Facades\Helpers\Reflection as ReflectionHelper;
use InvalidArgumentException;
use ReflectionClass;

final class Call
{
    /**
     * Gets the result of executing code in the specified class.
     *
     * @param  Closure|callable|string  $class
     * @param  string  $method
     * @param  mixed  ...$parameters
     *
     * @throws \ReflectionException
     *
     * @return mixed
     */
    public function run($class, string $method, ...$parameters)
    {
        $this->validate($class);

        if ($value = $this->callback($class, $method, ...$parameters)) {
            return $value;
        }

        $reflect = $this->reflection($class)->getMethod($method);

        if (! $reflect->isStatic() && ! InstanceHelper::of($class, Closure::class)) {
            $class = $this->resolve($class);
        }

        return call_user_func([$class, $method], ...$parameters);
    }

    /**
     * Gets the result of executing code in the specified class if method exist.
     *
     * @param  Closure|callable|string  $class
     * @param  string  $method
     * @param  mixed  ...$parameters
     *
     * @throws \ReflectionException
     *
     * @return mixed
     */
    public function runExists($class, string $method, ...$parameters)
    {
        $this->validate($class);

        if ($value = $this->callback($class, $method, ...$parameters)) {
            return $value;
        }

        if (method_exists($class, $method)) {
            return $this->run($class, $method, ...$parameters);
        }

        return null;
    }

    /**
     * Calls the object's methods one by one and returns the first non-empty value.
     *
     * @param  Closure|callable|string  $class
     * @param  string|array  $methods
     * @param  mixed  ...$parameters
     *
     * @throws \ReflectionException
     *
     * @return mixed
     */
    public function runMethods($class, $methods, ...$parameters)
    {
        if ($value = $this->callback($class, $methods, ...$parameters)) {
            return $value;
        }

        foreach (ArrHelper::wrap($methods) as $method) {
            if ($value = $this->runExists($class, $method, ...$parameters)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * Calls a method of an object that matches a class.
     *
     * @param  array  $map
     * @param  mixed  $value
     * @param  mixed  ...$parameters
     *
     * @throws \ReflectionException
     * @return mixed|null
     */
    public function runOf(array $map, $value, ...$parameters)
    {
        if ($this->validated($value)) {
            foreach ($map as $class => $method) {
                if (InstanceHelper::of($value, $class)) {
                    return $this->runExists($value, $method, ...$parameters);
                }
            }
        }

        return null;
    }

    /**
     * Gets the result of executing code in the specified class, if allowed.
     *
     * @param  bool  $when
     * @param  Closure|callable|string  $class
     * @param  string  $method
     * @param  mixed  ...$parameters
     *
     * @throws \ReflectionException
     *
     * @return mixed|null
     */
    public function when(bool $when, $class, string $method, ...$parameters)
    {
        return $when ? $this->run($class, $method, ...$parameters) : null;
    }

    protected function callback($class, ...$parameters)
    {
        if (is_callable($class)) {
            return $class(...$parameters);
        }

        return null;
    }

    protected function resolve($class)
    {
        return new $class();
    }

    protected function reflection($class): ReflectionClass
    {
        return ReflectionHelper::resolve($class);
    }

    protected function validate($class): void
    {
        if (! $this->validated($class)) {
            throw new InvalidArgumentException('Argument #1 must be either a class reference or an instance of a class, ' . gettype($class) . ' given.');
        }
    }

    protected function validated($class): bool
    {
        return is_callable($class) || InstanceHelper::exists($class) || IsHelper::object($class) || InstanceHelper::of($class, Closure::class);
    }
}
