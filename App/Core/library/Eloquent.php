<?php

namespace App\Core\library;

use App\Core\Services\DBService;
use Exception as ExceptionAlias;

class Eloquent extends DBService
{

    /**
     * @param $id
     * @return array|false|mixed|void|null
     * @throws ExceptionAlias
     */
    public function find($id)
    {
        $results = parent::find($id);
        if (empty($results))
            return null;

        return $this->getWithModel([$results])[0];
    }

    /**
     * @return object|array
     */
    public function all(): object|array
    {
        $results = parent::all();
        return $this->getWithModel($results);
    }


    /**
     * @param int $limit
     * @return object|array
     * @throws ExceptionAlias
     */
    public function take(int $limit = 1): object|array
    {
        $results = parent::take($limit);
        return $this->getWithModel($results);
    }

    /**
     * @return object|array
     */
    public function get(): object|array
    {
        $results = parent::get();
        return $this->getWithModel($results);
    }

    /**
     * @return mixed
     * @throws ExceptionAlias
     */
    public function first(): mixed
    {
        return $this->orderBy("id", "DESC")->take(1)[0] ?? null;
    }

    /**
     * @param $model
     * @param null $innerKey
     * @param null $outerKey
     * @return mixed
     */
    public function hasMany($model, $innerKey = null, $outerKey = null): mixed
    {
        $outerKey = $outerKey ?? 'id';
        $ok = strtolower(class_basename($model)).'_id';
        $innerKey = isset($innerKey) ? $this->$innerKey : $this->$ok;

        return (new $model())->where($outerKey,$innerKey)->get();
    }

    /**
     * @param $model
     * @param null $innerKey
     * @param null $outerKey
     * @return mixed
     */
    public function belongsTo($model, $innerKey = null, $outerKey = null): mixed
    {
        $outerKey = $outerKey ?? 'id';
        $ok = strtolower(class_basename($model)).'_id';
        $innerKey = isset($outerKey) ? $this->$outerKey : $this->$ok;

        return (new $model())->where($outerKey,$innerKey)->first();
    }

    /**
     * @param $model
     * @param null $innerKey
     * @param null $outerKey
     * @return mixed
     */
    public function hasOne($model, $innerKey = null, $outerKey = null): mixed
    {
        $outerKey = $outerKey ?? 'id';
        $ok = strtolower(class_basename($model)).'_id';
        $innerKey = isset($innerKey) ? $this->$innerKey : $this->$ok;

        return (new $model())->where($outerKey,$innerKey)->first();
    }

    /**
     * @param $model
     * @param null $innerKey
     * @param null $outerKey
     * @return array
     */
    public function belongsToMany($model, $innerKey = null, $outerKey = null): array
    {
        $tables = [strtolower(class_basename($model)),strtolower(class_basename($this))];
        sort($tables);
        $third_table = join('_',$tables);

        $innerKey = $innerKey ?? strtolower(class_basename($this)).'_id';
        $outerKey = $outerKey ?? 'id';

        $results = \App\Core\Facades\DB::table($third_table)->where($innerKey,$this->$outerKey)->get();
        return array_map(function($value) use ($model){
            $valueKey = strtolower(class_basename($model)).'_id';
            return (new $model)->where('id',$value->$valueKey)->first();
        },$results);
    }
}