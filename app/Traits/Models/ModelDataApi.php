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
        $this->id = database()->lastInsertId();
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

    # $wheres pattern: 'column.operand' => value
    public static function select(array $columns = ['*'], array $wheres = [], int $limit = 50, int $offset = 0): Collection
    {
        $columns = implode(', ', $columns);
        $binds = [];
        $values = [];

        foreach ($wheres as $column => $condition) {
            [$columnName, $operator] = explode('.', $column);

            if ($operator === 'in') {
                $placeholders = implode(', ', array_fill(0, count($condition), '?'));
                $binds[] = "{$columnName} in ({$placeholders})";
                $values = array_merge($values, $condition);
            } else {
                $binds[] = "{$columnName} {$operator} ?";
                $values[] = $condition;
            }
        }

        $binds = implode(' and ', $binds);
        $table = (new \ReflectionProperty(self::class, 'table'))->getValue(new static);

        $sql = "select $columns from $table ";
        $sql .= !empty($wheres) ? "WHERE $binds " : "";
        $sql .= $limit > 0 ? "limit $limit offset $offset" : "";

        $useLazy = $limit === 0 || $limit > 100;
        $results = $useLazy ? DB::queryLazy($sql, $values) : DB::query($sql, $values);
        $modelsToReturn = new Collection();

        foreach ($results as $result) {
            $modelsToReturn->add(new static((array) $result));
        }

        return $modelsToReturn;
    }

    public static function find(int|array $id): static|null|Collection
    {
        $isArray = is_array($id);
        $columnOperand = $isArray ? 'id.in' : 'id.=';
        $data = self::select(wheres: [
            $columnOperand => $id
        ], limit: $isArray ? count($id) : 1);
        return $isArray ? $data : $data->first();
    }

    public static function first(array $columns = ['*']): ?static
    {
        return self::select(
            $columns,
            limit: 1,
        )->first();
    }
}
