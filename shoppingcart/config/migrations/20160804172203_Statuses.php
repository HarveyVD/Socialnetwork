<?php
use Migrations\AbstractMigration;

class Statuses extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('statuses');
        
        $table->addColumn('user_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('parent_id', 'integer', [
            'null' => true,
        ]);
        $table->addColumn('body', 'text', [
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
