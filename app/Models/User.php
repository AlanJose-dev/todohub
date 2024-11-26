<?php

namespace App\Models;

class User extends Model
{
    protected string $table = 'users';

    protected array $fillableColumns = [
        'name',
        'email',
        'password',
    ];

    protected array $casts = [];

    public function boot(): void
    {
        //
    }

    public static function created(callable $callback): void
    {
        // TODO: Implement created() method.
    }

    public static function updated(callable $callback): void
    {
        // TODO: Implement updated() method.
    }

    public static function deleted(callable $callback): void
    {
        // TODO: Implement deleted() method.
    }
}