<?php

namespace Helldar\Support\Laravel\Models;

use Illuminate\Container\Container;

/**
 * Instead, use `Helldar\LaravelSupport\Traits\InitModelHelper`
 * from `andrey-helldar/laravel-support` package.
 *
 * @deprecated Will be removed from version 2.0
 */
trait InitModelHelper
{
    /** @var \Helldar\Support\Laravel\Models\ModelHelper */
    protected static $model_helper;

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return \Helldar\Support\Laravel\Models\ModelHelper
     */
    protected function model(): ModelHelper
    {
        if (static::$model_helper === null) {
            static::$model_helper = Container::getInstance()
                ->make(ModelHelper::class);
        }

        return static::$model_helper;
    }
}
