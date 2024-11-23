<?php

namespace App\Models;

class User extends Model
{
    protected string $table = 'users';

    protected string $primaryKey = 'id';

    protected array $columns = [
        'name',
        'email',
        'password',
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
