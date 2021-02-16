<?php
use Migrations\AbstractMigration;

class CreateFsjsCapitals extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        // 元入金テーブル
        // ※1/1(期首)の元入金。最低限必要な項目のみ      
        $table = $this->table('fsjs_capitals');
        
        // 西暦(年)
        $table->addColumn('yyyy', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        
        // 現金
        $table->addColumn('m1', 'integer', [
            'default' => 0,
            'limit' => 11,
            'null' => false,
        ]);
        
        // その他の預金
        $table->addColumn('m2', 'integer', [
            'default' => 0,
            'limit' => 11,
            'null' => false,
        ]);
        
        // 前払金
        $table->addColumn('m3', 'integer', [
            'default' => 0,
            'limit' => 11,
            'null' => false,
        ]);
        
        // 未払金
        $table->addColumn('m4', 'integer', [
            'default' => 0,
            'limit' => 11,
            'null' => false,
        ]);
        
        $table->addColumn('created_at', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('updated_at', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        
        $table->addIndex([
            'yyyy',
        ], [
            'name' => 'UNIQUE_YYYY',
            'unique' => true,
        ]);
        
        $table->create();
    }
}
