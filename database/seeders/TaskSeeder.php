<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class TaskSeeder extends AbstractSeed
{
    private Faker\Generator $faker;

    public function __construct() {
        parent::__construct();
        $this->faker = \Faker\Factory::create();
    }

    public function getDependencies(): array
    {
        return [
            'UserSeeder',
        ];
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
        $table = $this->table('tasks');
        $priorities = ['low', 'normal', 'high',];
        $completionDate = [\Carbon\Carbon::now()->format('Y-m-d H:i:s'), null];
        for ($i = 0; $i < 100; $i++) {
            $this->table('tasks')->insert([
                'title' => $this->faker->sentence(),
                'description' => $this->faker->paragraph(),
                'completed' => $this->faker->boolean(),
                'priority' => $this->faker->randomElement($priorities),
                'expected_completion_date' => $this->faker->randomElement($completionDate),
                'completion_date' => $this->faker->randomElement($completionDate),
                'user_id' => $this->faker->numberBetween(1, 100),
            ])->saveData();
        }
    }
}
