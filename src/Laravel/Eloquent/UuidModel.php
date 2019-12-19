<?php

namespace Helldar\Support\Laravel\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

abstract class UuidModel extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (!($model->{$model->primaryKey} ?? false)) {
                $model->{$model->primaryKey} = (string) Uuid::generate(4);
            }
        });
    }

    public function getRouteKeyName()
    {
        return $this->primaryKey;
    }
}
