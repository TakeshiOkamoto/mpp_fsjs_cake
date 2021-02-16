<?php
use Migrations\AbstractSeed;

// 追加分
use Cake\Datasource\ConnectionManager;
use Cake\Core\Exception\Exception;

/**
 * FsjsAccounts seed.
 */
class FsjsAccountsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
          [
           'id'           => 1,
           'name'         => '事業主貸',
           'types'        => 1,
           'expense_flg'  => 0,
           'sort_list'    => 1,
           'sort_expense' => -1,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],
          [
           'id'           => 2,
           'name'         => '事業主借',
           'types'        => 2,
           'expense_flg'  => 0,
           'sort_list'    => 2,
           'sort_expense' => -1,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],
          [
           'id'           => 3,
           'name'         => '現金',
           'types'        => 3,
           'expense_flg'  => 0,
           'sort_list'    => 3,
           'sort_expense' => -1,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],
          [
           'id'           => 4,
           'name'         => 'その他の預金',
           'types'        => 3,
           'expense_flg'  => 0,
           'sort_list'    => 4,
           'sort_expense' => -1,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],  
          [
           'id'           => 5,
           'name'         => '未払金',
           'types'        => 3,
           'expense_flg'  => 0,
           'sort_list'    => 5,
           'sort_expense' => -1,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],
          [
           'id'           => 6,
           'name'         => '通信費',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 12,
           'sort_expense' => 5,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],  
          [
           'id'           => 7,
           'name'         => '消耗品費',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 24,
           'sort_expense' => 10,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],
          [
           'id'           => 8,
           'name'         => '雑費',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 25,
           'sort_expense' => 18,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],      
          [
           'id'           => 9,
           'name'         => '旅費交通費',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 11,
           'sort_expense' => 4,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],  
          [
           'id'           => 10,
           'name'         => '損害保険料',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 15,
           'sort_expense' => 8,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],   
          [
           'id'           => 11,
           'name'         => '荷造運賃',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 9,
           'sort_expense' => 2,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ], 
          [
           'id'           => 12,
           'name'         => '売上(収入)',
           'types'        => 2,
           'expense_flg'  => 0,
           'sort_list'    => 7,
           'sort_expense' => -1,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],  
          [
           'id'           => 13,
           'name'         => '前払金',
           'types'        => 3,
           'expense_flg'  => 0,
           'sort_list'    => 6,
           'sort_expense' => -1,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],                                                                                                                        
          [
           'id'           => 14,
           'name'         => '外注工賃',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 20,
           'sort_expense' => 14,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],  
          [
           'id'           => 15,
           'name'         => '租税公課',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 8,
           'sort_expense' => 1,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],  
          [
           'id'           => 16,
           'name'         => '水道光熱費',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 10,
           'sort_expense' => 3,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],   
          [
           'id'           => 17,
           'name'         => '広告宣伝費',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 13,
           'sort_expense' => 6,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ], 
          [
           'id'           => 18,
           'name'         => '接待交際費',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 14,
           'sort_expense' => 7,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],   
          [
           'id'           => 19,
           'name'         => '修繕費',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 16,
           'sort_expense' => 9,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],                                                                
          [
           'id'           => 20,
           'name'         => '利子割引料',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 21,
           'sort_expense' => 15,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],   
          [
           'id'           => 21,
           'name'         => '地代家賃',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 22,
           'sort_expense' => 16,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],   
          [
           'id'           => 22,
           'name'         => '貸倒金',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 23,
           'sort_expense' => 17,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ], 
          [
           'id'           => 23,
           'name'         => '減価償却費',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 17,
           'sort_expense' => 11,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],
          [
           'id'           => 24,
           'name'         => '福利厚生費',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 18,
           'sort_expense' => 12,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ],  
          [
           'id'           => 25,
           'name'         => '給料賃金',
           'types'        => 1,
           'expense_flg'  => 1,
           'sort_list'    => 19,
           'sort_expense' => 13,
           'created_at' => '2021-02-14 00:00:00',
           'updated_at' => '2021-02-14 00:00:00', 
          ], 
        ];
              
        // トランザクション
        $con = ConnectionManager::get('default');
        $con->begin();          
        try{
            $con->execute('TRUNCATE TABLE fsjs_accounts'); 
             
            $table = $this->table('fsjs_accounts');
            $table->insert($data)->save(); 
            
            // コミット
            $con->commit();
            
        // ロールバック 
        } catch (Exception $e) {
            $con->rollback();
            throw new Exception($e);
        }
 
    }
}
