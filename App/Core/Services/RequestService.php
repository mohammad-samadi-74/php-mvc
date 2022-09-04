<?php

namespace App\Core\Services;

class RequestService
{
    protected array $requests = [];

    public function __construct()
    {

        foreach ($_REQUEST as $key => $value) {
            $this->requests[$key] = $value;
        }

    }

    /**
     * @param $data
     */
    public function put($data)
    {

        foreach ($data as $key => $value) {
            if (is_int($key)) {
                unset($data[$key]);
            }
        }

        $this->requests = array_merge($this->requests, $data);
    }

    public function all(): array
    {
        $this->getWithModel();
        return $this->requests;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function get($name)
    {
        $this->getWithModel();
        return $this->requests[$name] ?? null;
    }

    protected function getWithModel()
    {
        $requests = $this->requests;

        array_walk($this->requests, function (&$value, $key) {
            $modelName = 'App\Models\\' . ucfirst($key);

            if (class_exists($modelName)) {
                $model = new $modelName();
                if ($model->find((int)$value)) {
                    foreach ($model->find((int)$value)[0] as $variable => $mount) {
                        $model->data[$variable] = $mount;
                    }
                    $value = $model;
                }
            }
        });

    }

    public function resetRequests()
    {
        $this->data = [];
    }
}