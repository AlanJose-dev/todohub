<?php

namespace App\Models;

use App\Facades\DB;

#[\AllowDynamicProperties]
abstract class Model
{
    protected string $table;

    protected string $primaryKey;

    protected array $columns;

    protected ?\PDO $connection = null;

    public function __construct()
    {
        $this->connection = DB::connection();
    }

    protected function saveByGivenData(array $data): self
    {
        $givenColumns = array_keys($data);
        $givenValues = array_values($data);

        if(count($givenColumns) !== count($givenValues)) {
            throw new \Exception("The number of columns does not match the number of values");
        }

        if(count($givenColumns) !== count($this->columns)) {
            throw new \Exception("The number of given columns does not match of model columns");
        }

        $sql = 'insert into ' . $this->table . '(' . implode(', ', $givenColumns) . ') values (';
        array_walk($givenColumns, function($column) use (&$sql, $givenColumns) {
            $sql .= $column === end($givenColumns) ? ":$column" : ":$column, ";
        }); # Adding named placeholders.
        $sql .= ')';

        $statement = $this->connection->prepare($sql);
        $statement->execute($data);

        $primaryKeyName = $this->primaryKey;
        $this->$primaryKeyName = $this->connection->lastInsertId();
        foreach($data as $column => $value) {
            $this->$column = $value;
        }
        return $this;
    }

    protected function saveByDynamicProperties(Model $model): self
    {
        $properties = get_object_vars($model);
        return $this->saveByGivenData($properties);
    }

    public static function create(array $data): self
    {
        $model = new static();
        return $model->save($data);
    }

    public function save(?array $data): self
    {
        if(is_null($data)) {
            return $this->saveByDynamicProperties($this);
        }
        return $this->saveByGivenData($data);
    }

    public function __sleep(): array
    {
        $this->connection = null;
        return $this->columns;
    }

    public function __wakeup(): void
    {
        $this->connection = DB::connection();
    }
}
