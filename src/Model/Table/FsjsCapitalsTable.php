<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FsjsCapitals Model
 *
 * @method \App\Model\Entity\FsjsCapital get($primaryKey, $options = [])
 * @method \App\Model\Entity\FsjsCapital newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FsjsCapital[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FsjsCapital|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FsjsCapital saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FsjsCapital patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FsjsCapital[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FsjsCapital findOrCreate($search, callable $callback = null, $options = [])
 */
class FsjsCapitalsTable extends Table
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

        $this->setTable('fsjs_capitals');
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
            ->integer('yyyy')
            ->requirePresence('yyyy', 'create')
            ->notEmptyString('yyyy')
            ->range('yyyy', [1989, 2099], __('1989から2099までの値を入力してください。'))
            ->add('yyyy', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => __('年の値は既に存在しています。')]);

        $validator
            ->integer('m1')
            ->notEmptyString('m1')
            ->range('m1', [0, 2147483647], __('0から2147483647までの値を入力してください。'));

        $validator
            ->integer('m2')
            ->notEmptyString('m2')
            ->range('m2', [0, 2147483647], __('0から2147483647までの値を入力してください。'));
            
        $validator
            ->integer('m3')
            ->notEmptyString('m3')
            ->range('m3', [0, 2147483647], __('0から2147483647までの値を入力してください。'));
            
        $validator
            ->integer('m4')
            ->notEmptyString('m4')
            ->range('m4', [0, 2147483647], __('0から2147483647までの値を入力してください。'));
            
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
        // $rules->add($rules->isUnique(['yyyy']));

        return $rules;
    }
}
