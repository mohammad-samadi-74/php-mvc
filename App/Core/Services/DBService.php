<?php

namespace App\Core\Services;

use App\Core\library\DB;
use App\Models\Model;
use Exception;

class DBService
{
    use DB;

    /**
     * @param $id
     * @return array|false|void
     * @throws Exception
     */
    public function find($id)
    {
        if (!isset($id) || !is_int($id))
            throw new Exception('please enter an valid id');

        $results = $this->select()->where('id', $id)->addWheres()->fetchResults();
        if (empty($results))
            return null;

        return $results[0];
    }

    /**
     * @return object|array
     */
    public function all(): object|array
    {
        return $this->select()->addOrderBy()->fetchResults();
    }

    /**
     * @param int $limit
     * @return object|array
     * @throws Exception
     */
    public function take(int $limit = 1): object|array
    {
        return $this->select()->limit($limit)->addWheres()->addOrderBy()->addLimit($limit)->fetchResults();
    }

    /**
     * @return object|array
     */
    public function get(): object|array
    {
        return $this->select()->addWheres()->addOrderBy()->fetchResults();
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function first(): mixed
    {
        return $this->orderBy("id", "DESC")->take(1)[0] ?? null;
    }

    /**
     * @param $key
     * @param $value
     * @param string $operator
     * @return $this
     * @throws Exception
     */
    public function where($key, $value, string $operator = "="): static
    {
        if (!isset($key) || !isset($value)) {
            throw_exception('please enter an valid key and value in where() method !');
        }
        $this->wheres[] = [$key, $value, $operator];
        return $this;
    }

    /**
     * @param int $number
     * @return $this
     * @throws Exception
     */
    public function limit(int $number = 1): static
    {
        if (!is_int($number)) {
            throw_exception('please enter an valid number in limit() method !');
        }

        $this->limit = $number;
        return $this;
    }

    /**
     * @param $field
     * @param string $flag
     * @return $this
     * @throws Exception
     */
    public function orderBy($field, string $flag = "ASC"): static
    {
        if (empty($field) || !is_string($field))
            throw_exception('please enter an valid field in orderBy() method !');

        if (empty($field) || !is_string($field))
            throw_exception('please enter an valid string field in orderBy() method !');

        if (!in_array(strtoupper($flag), ['ASC', 'DESC']))
            throw_exception('please enter an valid flag [asc or desc] in orderBy() method !');

        $this->orderBy = [$field, $flag];
        return $this;
    }

    /**
     * @param array|object $data
     * @return object|array
     */
    protected function getWithModel(array|object $data): object|array
    {

        if ($data instanceof Model) {
            $data = [$data];
        }
        $model = get_class($this);

        array_walk($data, function (&$value, $key) use ($model) {
            $model = new $model();

            foreach ($value as $prop => $mount) {
                $model->data[$prop] = $mount;
            }
            $value = $model;
        });
        return $data;

    }
}