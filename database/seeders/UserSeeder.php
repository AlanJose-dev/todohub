<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    private Faker\Generator $faker;

    public function __construct() {
        parent::__construct();
        $this->faker = \Faker\Factory::create();
    }

    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $table = $this->table('users');
        for($i = 0; $i < 100; $i++) {
            $table->insert([
                'name' => $this->faker->name(),
                'email' => $this->faker->email,
                'password' => password_hash('password', PASSWORD_BCRYPT),
            ])->saveData();
        }
    }
}
