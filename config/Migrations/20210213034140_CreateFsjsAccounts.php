<?php
use Migrations\AbstractMigration;

class CreateFsjsAccounts extends AbstractMigration
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
        $table = $this->table('fsjs_accounts');
        
        // 名前
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        
        // 種類(1:借方 2:貸方 3:両方)
        $table->addColumn('types', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);

        // 経費フラグ(true:経費 false:経費以外)
        $table->addColumn('expense_flg', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        
        // 表示順序(リスト用)
        $table->addColumn('sort_list', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        
        // 表示順序(経費用) ※損益計算書で使用する経費以外は-1
        $table->addColumn('sort_expense', 'integer', [
            'default' => null,
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
            'name',
        ], [
            'name' => 'UNIQUE_NAME',
            'unique' => true,
        ]);
        $table->addIndex([
            'types',
        ], [
            'name' => 'BY_TYPES',
            'unique' => false,
        ]);
        $table->addIndex([
            'expense_flg',
        ], [
            'name' => 'BY_EXPENSE_FLG',
            'unique' => false,
        ]);
        $table->create();
    }
}
