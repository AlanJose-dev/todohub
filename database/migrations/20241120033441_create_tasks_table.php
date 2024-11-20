<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTasksTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('tasks');
        $table->addColumn('title', 'string', ['length' => 255]);
        $table->addColumn('description', 'text', ['null' => true]);
        $table->addColumn('completed', 'boolean', ['default' => false]);
        $table->addColumn('priority', 'enum', ['values' => ['low', 'normal', 'high'], 'default' => 'normal']);
        $table->addColumn('expected_completion_date', 'datetime', ['null' => true]);
        $table->addColumn('completion_date', 'timestamp', ['null' => true]);
        $table->addColumn('user_id', 'integer', ['signed' => false]);
        $table->addTimestamps();
        $table->addForeignKey('user_id', 'users', 'id');
        $table->addIndex('title');
        $table->create();
    }

    public function down(): void
    {
        if($this->hasTable('tasks')) {
            $table = $this->table('tasks');
            $table->dropForeignKey('user_id');
            $table->drop();
        }
    }
}
