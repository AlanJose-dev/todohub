<?php

namespace App\Traits\Models;

use App\Facades\Support\DB;
use Illuminate\Support\Collection;

trait ModelDataApi
{
    public function save(): static
    {
        $properties = get_object_vars($this);
        $this->removeStandardAttributes($properties);
        DB::insert(
            $this->table,
            $properties,
        );
        return $this;
    }

    public function update(): static
    {
        $properties = get_object_vars($this);
        $this->removeStandardAttributes($properties);
        DB::update(
            $this->table,
            $properties,
            'id',
            '=',
            $this->id,
        );
        return $this;
    }

    public function delete(): bool
    {
        return DB::delete(
            $this->table,
            'id',
            '=',
            $this->id,
        );
    }

    public static function create(array $data): static
    {
        return (new static($data))->save();
    }

    # $wheres pattern: 'column.operand' => value.
    public static function select(array $columns = ['*'], array $wheres = [], int $limit = 0, int $offset = 0): Collection
    {
        $columns = implode(', ', $columns);
        $binds = !empty($wheres) ? array_map(function ($value, $column) {
            [$column, $operator] = explode('.', $column);
            return "{$column} {$operator} ?";
        }, $wheres, array_keys($wheres)) : [];
        $binds = implode(' and ', $binds);
        $values = array_values($wheres);
        $table = (new \ReflectionProperty(self::class, 'table'))->getValue(new static);
        $sql = "select $columns from $table ";
        $sql .= !empty($wheres) ? "where $binds " : "";
        $sql .= $limit > 0 ? "limit $limit offset $offset" : "";
        $results = DB::queryLazy($sql, $values);
        $modelsToReturn = new Collection();
        foreach ($results as $result) {
            $modelsToReturn->add(new static($result));
        }
        return $modelsToReturn;
    }

    public static function find(int|array $id): static|null|array
    {
        $data = self::select(wheres: []);
    }
}
