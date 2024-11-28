<?php

namespace Model;

use App\Facades\Support\DB;
use App\Models\Model;
use App\Models\User;
use PHPUnit\Framework\TestCase;

final class ModelDataHandlingTest extends TestCase
{
    private array $tables = [
        'users'
    ];

    protected function setUp(): void
    {
        parent::setUp();
        foreach ($this->tables as $table) {
            DB::truncate($table, true);
        }
    }

    private function createModel(): Model
    {
        $standardData = [
            'name' => 'Test user',
            'email' => 'test@example.app.com',
            'password' => password_hash('password', PASSWORD_BCRYPT),
        ];
        return User::create($standardData);
    }

    public function testModelCanBeCreated(): void
    {
        $this->assertInstanceOf(User::class, User::create([
            'name' => 'Irineu',
            'email' => 'irineu@gmail.com',
            'password' => password_hash('password', PASSWORD_BCRYPT),
        ]));
    }

    public function testModelCanBeSelected(): void
    {
        $this->assertIsIterable(User::select(limit: 1));
    }

    public function testModelCanBeUpdated(): void
    {
        $model = $this->createModel();
        $model->name = 'Updated name';
        $model->update();
        $this->assertEquals('Updated name', User::first()->name);
    }

    public function testModelCanBeDeleted(): void
    {
        $model = $this->createModel();
        $id = $model->id;
        $model->delete();
        $this->assertNull(User::find($id));
    }
}
