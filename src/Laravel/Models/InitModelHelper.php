<?php

namespace Helldar\Support\Laravel\Models;

use Illuminate\Container\Container;

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
