<?php
use Migrations\AbstractMigration;

class CreateFsjsJournals extends AbstractMigration
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
        // 仕訳帳テーブル
        $table = $this->table('fsjs_journals');
        
        // 年
        $table->addColumn('yyyy', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        
        // 月
        $table->addColumn('mm', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        
        // 日
        $table->addColumn('dd', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        
        // 科目コード(借方)
        $table->addColumn('debit_account_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        
        // 科目コード(貸方)
        $table->addColumn('credit_account_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        
        // 金額
        $table->addColumn('money', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);

        // 摘要
        $table->addColumn('summary', 'string', [
            'default' => null,
            'limit' => 255,
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
            'name' => 'BY_YYYY',
            'unique' => false,
        ]);
        $table->addIndex([
            'mm',
        ], [
            'name' => 'BY_MM',
            'unique' => false,
        ]);
        $table->addIndex([
            'dd',
        ], [
            'name' => 'BY_DD',
            'unique' => false,
        ]);
        $table->create();
    }
}
