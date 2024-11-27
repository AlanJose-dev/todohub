<?php

namespace App\Interfaces\Models;

use Illuminate\Support\Collection;

interface ModelDataApiInterface
{
    public function save(): static;

    public function update(): static;

    public function delete(): bool;

    public static function create(array $data): static;

    public static function select(array $columns = ['*'], array $whereColumns = [], int $limit = 1000, int $offset = 0): Collection;

    public static function find(int|array $id): static|null|Collection;

    public static function first(): ?static;
}
