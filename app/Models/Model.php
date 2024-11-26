<?php

namespace App\Models;

use App\Facades\Support\DB;
use App\Interfaces\Models\ModelDataApiInterface;
use App\Traits\Models\ModelBootWorker;
use App\Traits\Models\ModelDataApi;

#[\AllowDynamicProperties]
abstract class Model implements ModelDataApiInterface
{
    use ModelDataApi;

    use ModelBootWorker;

    protected string $table;

    protected array $fillableColumns = [];

    protected array $casts = [];

    abstract public function boot(): void;

    abstract public static function created(callable $callback): void;

    abstract public static function updated(callable $callback): void;

    abstract public static function deleted(callable $callback): void;

    public function __construct(array $data = [])
    {
        self::callBootMethodIfExists();
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}
