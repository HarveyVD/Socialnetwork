<?php
use Migrations\AbstractMigration;

class Friends extends AbstractMigration
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
        $table = $this->table('friends');
        
        $table->addColumn('user_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('friend_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('accepted', 'boolean', [
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
