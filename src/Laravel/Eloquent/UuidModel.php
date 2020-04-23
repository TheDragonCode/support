<?php

namespace Helldar\Support\Laravel\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * Instead, use `Helldar\LaravelSupport\Eloquent\UuidModel`
 * from `andrey-helldar/laravel-support` package.
 *
 * @deprecated Will be removed from version 2.0
 */
abstract class UuidModel extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! ($model->{$model->primaryKey} ?? false)) {
                $model->{$model->primaryKey} = (string) Uuid::generate(4);
            }
        });
    }

    public function getRouteKeyName()
    {
        return $this->primaryKey;
    }
}
