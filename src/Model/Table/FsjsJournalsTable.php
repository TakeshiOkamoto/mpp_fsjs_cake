<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

// 追加分
use Cake\Datasource\ConnectionManager;

/**
 * FsjsJournals Model
 *
 * @method \App\Model\Entity\FsjsJournal get($primaryKey, $options = [])
 * @method \App\Model\Entity\FsjsJournal newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FsjsJournal[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FsjsJournal|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FsjsJournal saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FsjsJournal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FsjsJournal[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FsjsJournal findOrCreate($search, callable $callback = null, $options = [])
 */
class FsjsJournalsTable extends Table
{

///////////////////////////////////////////////////////////////////////////////

    // 対象科目の合計金額を取得する
    public function getTargetTotal($v, $obj, $target_id, $edit_id)
    {
        if (!($v['credit_account_id'] == $target_id ||  $v['debit_account_id'] == $target_id)){
            return 0;
        }
        
        // 元入金テーブル
        $con = ConnectionManager::get('default');
        $sql = "SELECT * FROM fsjs_capitals WHERE yyyy = :yyyy";
        $capital = $con->execute($sql, ['yyyy' => $v['yyyy']])->fetchAll('assoc');
        
        // 編集
        if($edit_id != ""){
          
            // 借方
            $sql   = "SELECT IFNULL(SUM(money),0) AS money FROM fsjs_journals " .
                     "WHERE yyyy = :yyyy AND debit_account_id = :target_id AND id <> :edit_id";
            $debit = $con->execute($sql, ['yyyy' => $v['yyyy'], 
                                          'target_id' => $target_id,
                                          'edit_id' => $edit_id])->fetchAll('assoc');
                       
            // 貸方
            $sql   = "SELECT IFNULL(SUM(money),0) AS money FROM fsjs_journals " .
                     "WHERE yyyy = :yyyy AND credit_account_id = :target_id AND id <> :edit_id";
            $credit = $con->execute($sql, ['yyyy' => $v['yyyy'], 
                                          'target_id' => $target_id,
                                          'edit_id' => $edit_id])->fetchAll('assoc');
        // 新規
        }else{
            // 借方
            $sql   = "SELECT IFNULL(SUM(money),0) AS money FROM fsjs_journals " .
                     "WHERE yyyy = :yyyy AND debit_account_id = :target_id";
            $debit = $con->execute($sql, ['yyyy' => $v['yyyy'], 
                                          'target_id' => $target_id])->fetchAll('assoc');
                       
            // 貸方
            $sql   = "SELECT IFNULL(SUM(money),0) AS money FROM fsjs_journals " .
                     "WHERE yyyy = :yyyy AND credit_account_id = :target_id";
            $credit = $con->execute($sql, ['yyyy' => $v['yyyy'], 
                                          'target_id' => $target_id])->fetchAll('assoc');
        }

        // 未払金
        if ($target_id == 5){
            // 借方
            if ($v['debit_account_id'] == $target_id){              
                $total = ($debit[0]['money'] + $v['money']) - ($capital[0][$obj] + $credit[0]['money']); 
            // 貸方  
            }else{
               $total = ($debit[0]['money']) - ($capital[0][$obj] + $credit[0]['money'] + $v['money']); 
            }    
            
        // 現金、その他の預金、前払金       
        }else{
            // 借方
            if ($v['debit_account_id'] == $target_id){      
                $total = ($capital[0][$obj] + $debit[0]['money'] + $v['money']) - $credit[0]['money'];
            // 貸方  
            }else{
               $total = ($capital[0][$obj] + $debit[0]['money']) - $credit[0]['money'] - $v['money'];
            }                
        }
        
        return  $total;
    }
    
    // 現金、その他の預金、前払金、未払金の整合性チェック
    public function money_check($v, $id)
    {
         // 仕訳帳は1/1から順番に記帳しないと矛盾が生じてエラーが多発しやすいです。
         // エラーチェックを解除したい場合は次のコードを有効にして下さい。
         
         // return true;
          
         // 現金 
         $total = $this->getTargetTotal($v, "m1", 3, $id);
         if($total < 0){
            return __("現金の合計が{0}円になります。この仕訳の前に「借方」に現金を追加して下さい。 例)借方(現金) 貸方(事業主借)", number_format($total));
         }
         
         // その他の預金
         $total = $this->getTargetTotal($v, "m2", 4, $id);
         if($total < 0){
             return __("その他の預金の合計が{0}円になります。※他の仕訳の「その他の預金」を確認して下さい。", number_format($total));
         }
                  
         // 前払金
         $total = $this->getTargetTotal($v, "m3", 13, $id);
         if($total < 0){
             return __("前払金の合計が{0}円になります。※他の仕訳の「前払金」を確認して下さい。", number_format($total));
         }
         
         // 未払金
         $total = $this->getTargetTotal($v, "m4", 5, $id);
         if($total > 0){
             return __("このままだと未払金を支払い過ぎます。({0}円多い) ※他の仕訳の「未払金」を確認して下さい。", number_format($total));          
         }

        return true;
    }     
    
///////////////////////////////////////////////////////////////////////////////
    
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('fsjs_journals');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        // --------------------------------
        //  タイムスタンプのカラム名変更
        // --------------------------------
        
        // CakePHP標準はcreated/modified
        // $this->addBehavior('Timestamp');
        
        // 以下にするとRails/Laravelと同じ
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at' => 'new',
                    'updated_at' => 'always'
                ]
            ]
        ]);
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('yyyy')
            ->requirePresence('yyyy', 'create')
            ->notEmptyString('yyyy')
            ->range('yyyy', [1989, 2099], __('1989から2099までの値を入力してください。'));

        $validator
            ->integer('mm')
            ->requirePresence('mm', 'create')
            ->notEmptyString('mm')
            ->range('mm', [1, 12], __('1から12までの値を入力してください。'));

        $validator
            ->integer('dd')
            ->requirePresence('dd', 'create')
            ->notEmptyString('dd')
            ->range('dd', [1, 31], __('1から31までの値を入力してください。'));
            
        $validator
            ->integer('debit_account_id')
            ->requirePresence('debit_account_id', 'create')
            ->notEmptyString('debit_account_id')
            ->notSameAs('debit_account_id', 'credit_account_id', __('借方と貸方に同一の科目を登録できません。'));
            
        $validator
            ->integer('credit_account_id')
            ->requirePresence('credit_account_id', 'create')
            ->notEmptyString('credit_account_id')
            ->notSameAs('credit_account_id', 'debit_account_id', __('借方と貸方に同一の科目を登録できません。'));
             
        $validator
            ->integer('money')
            ->requirePresence('money', 'create')
            ->notEmptyString('money')
            ->range('money', [1, 2147483647], __('1から2147483647までの値を入力してください。'))
            
            // カスタム
            ->add('money', [
                'custom' => [
                    'rule' => function($value, $context) { 

                                  // 独自のバリデーション(現金、その他の預金、前払金、未払金の整合性)
                                  if (!array_key_exists('id', $context['data'])){
                                      // 新規
                                      return $this->money_check($context['data'], "");
                                  }else{
                                      // 編集
                                      return $this->money_check($context['data'], $context['data']['id']);
                                  }
                              },
                    'message' => 'none',
                ],
            ]);                  

        $validator
            ->scalar('summary')
            ->maxLength('summary', 50)
            ->requirePresence('summary', 'create')
            ->notEmptyString('summary');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        return $rules;
    }
}
