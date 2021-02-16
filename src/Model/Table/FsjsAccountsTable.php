<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FsjsAccounts Model
 *
 * @method \App\Model\Entity\FsjsAccount get($primaryKey, $options = [])
 * @method \App\Model\Entity\FsjsAccount newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FsjsAccount[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FsjsAccount|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FsjsAccount saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FsjsAccount patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FsjsAccount[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FsjsAccount findOrCreate($search, callable $callback = null, $options = [])
 */
class FsjsAccountsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('fsjs_accounts');
        $this->setDisplayField('name');
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

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 20)
            ->requirePresence('name', 'create')
            ->notEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => __('名前の値は既に存在しています。')]);

        $validator
            ->integer('types')
            ->requirePresence('types', 'create')
            ->notEmptyString('types')
            ->range('types', [1, 3], __('種類を選択してください。'));

        $validator
            ->boolean('expense_flg')
            ->allowEmptyString('expense_flg');

        $validator
            ->integer('sort_list')
            ->requirePresence('sort_list', 'create')
            ->notEmptyString('sort_list')
            ->range('sort_list', [-1, 1000], __('-1 ～ 1000の値を入力してください。'));

        $validator
            ->integer('sort_expense')
            ->requirePresence('sort_expense', 'create')
            ->notEmptyString('sort_expense')
            ->range('sort_expense', [-1, 1000], __('-1 ～ 1000の値を入力してください。'));

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
        // 不要 
        // $rules->add($rules->isUnique(['name']));

        return $rules;
    }
}
