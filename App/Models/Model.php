<?php

namespace App\Models;

use App\Core\library\Eloquent;
use Exception;

class Model extends Eloquent
{

    public array $data = [];

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        if (method_exists($this,$name)){
            return $this->$name();
        }
        return $this->data[$name] ;
    }

    /**
     * @param $data
     * @return Model
     * @throws Exception
     */
    public function create($data): Model
    {
        $keys = join(',',array_keys($data));
        $values = ':'.join(',:',array_keys($data));

        $this->stm = $this->db->prepare("INSERT INTO {$this->table_name} ({$keys}) VALUES ({$values})");
        $this->bindValues($data);

        $status = $this->stm->execute();
        return $status ? $this->first() : false;
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $id = $this->id;
        $this->stm = $this->db->prepare("DELETE FROM {$this->table_name} WHERE id = $id");
        return $this->stm->execute();
    }

    /**
     * @param array $data
     * @return bool|Model
     */
    public function update(array $data): bool|Model
    {

        $query = "UPDATE {$this->table_name} SET";
        foreach($data as $key=>$value){
            $query .= " $key = :$key";
        }
        $query.=" Where id = {$this->id}";

        $this->stm = $this->db->prepare($query);
        $this->bindValues($data);
        $status = $this->stm->execute();
        return $status ? $this : false;

    }
}