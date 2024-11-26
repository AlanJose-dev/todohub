<?php

namespace Model;

use App\Facades\Support\DB;
use App\Models\User;
use PHPUnit\Framework\TestCase;

final class ModelDataHandlingTest extends TestCase
{
    public function testModelCanBeCreated(): void
    {
        $this->assertInstanceOf(User::class, User::create([
            'name' => 'Irineu',
            'email' => 'irineu@gmail.com',
            'password' => password_hash('password', PASSWORD_BCRYPT),
        ]));
        DB::truncate('users', true);
    }

    public function testModelCanBeSelected(): void
    {
//        $model = User::
    }
}
