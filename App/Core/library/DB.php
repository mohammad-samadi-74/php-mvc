<?php

namespace App\Core\library;

use Exception;
use PDO;

trait DB
{
    protected \PDO $db;
    protected string $table_name;
    protected \PDOStatement|false|string $stm;
    protected array $wheres = [];
    protected int $limit;
    protected array $orderBy;
    protected static array $migrations = [];

    /**
     * @throws Exception
     */
    public function __construct()
    {
        try {
            $this->db = new \PDO(env('DB_DRIVER') . ":host=" . env('DB_HOST') . ";dbname=" . env('DB_NAME'), env('DB_USERNAME'), env('DB_PASSWORD'));
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param array|null $fields
     * @return $this
     */
    protected function select(null|array $fields = null): static
    {
        $fields = (!isset($fields)) ? "*" : join(',', array_values($fields));
        $this->stm = "SELECT * FROM {$this->table_name}";
        return $this;
    }

    public function table($tableName): static
    {
        $this->table_name = $tableName;
        return $this;
    }

    /**
     * @param array $array_values
     */
    protected function bindValues(array $array_values)
    {

        foreach ($array_values as $key => $value) {
            $this->stm->bindValue(":$key", $value);
        }

    }

    /**
     * @return array|false|void
     */
    protected function fetchResults()
    {
        try {
            $this->stm = $this->db->prepare($this->stm);
            $this->stm->execute();
            return $this->stm->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function addWheres(): static
    {
        foreach ($this->wheres as $key => $where) {
            $value = is_int($where[1]) ? $where[1] : "'$where[1]'";
            $mark = $key == 0 ? "WHERE" : "AND";
            $this->stm .= " $mark $where[0] $where[2] $value ";
        }
        return $this;
    }

    protected function addLimit(): static
    {
        if (isset($this->limit)) {
            $this->stm .= " LIMIT {$this->limit} ";
        }
        return $this;
    }

    protected function addOrderBy(): static
    {
        if (isset($this->orderBy)) {
            $this->stm .= " ORDER BY {$this->orderBy[0]} {$this->orderBy[1]} ";
        }
        return $this;
    }

    public function prepare($query): static
    {
        $this->stm = $this->db->prepare($query);
        return $this;
    }

    public function execute(): bool|array
    {
        $this->stm->execute();
        return $this->stm->fetchAll();
    }
}