<?php

namespace Helldar\Support\Laravel\Models;

use Helldar\Support\Exceptions\Laravel\IncorrectModelException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ModelHelper
{
    private $models = [];

    /**
     * @param $model
     *
     * @return string
     * @throws IncorrectModelException
     */
    public function connection($model): ?string
    {
        return $this
            ->model($model)
            ->getConnectionName();
    }

    /**
     * @param $model
     *
     * @return string
     * @throws IncorrectModelException
     */
    public function table($model): string
    {
        return $this
            ->model($model)
            ->getTable();
    }

    /**
     * @param $model
     *
     * @return string
     * @throws IncorrectModelException
     */
    public function tableWithConnection($model): string
    {
        $connection = $this->connection($model);
        $table      = $this->table($model);

        return $connection
            ? $connection . '.' . $table
            : $table;
    }

    /**
     * @param $model
     *
     * @return string
     * @throws IncorrectModelException
     */
    public function primaryKey($model): string
    {
        return $this
            ->model($model)
            ->getKeyName();
    }

    public function className($model): string
    {
        if (is_string($model)) {
            return $model;
        }

        return get_class($model);
    }

    /**
     * @param $model
     *
     * @return array
     * @throws IncorrectModelException
     */
    public function fillable($model): array
    {
        return $this
            ->model($model)
            ->getFillable();
    }

    /**
     * @param mixed|Model $model
     * @param Request $request
     *
     * @return array
     * @throws IncorrectModelException
     */
    public function onlyFillable($model, $request): array
    {
        $fillable = $this->fillable($model);

        return $request->only($fillable);
    }

    /**
     * @param $model
     * @param mixed ...$except
     *
     * @return array
     * @throws IncorrectModelException
     */
    public function exceptFillable($model, ...$except): array
    {
        return array_diff($this->fillable($model), (array) $except);
    }

    /**
     * @param Model|string $model
     *
     * @return Model
     * @throws IncorrectModelException
     */
    public function model($model)
    {
        if ($model instanceof Model) {
            $name = get_class($model);

            return $this->models[$name] = $model;
        }

        if (is_string($model)) {
            return $this->models[$model] = new $model;
        }

        throw new IncorrectModelException($model);
    }
}
