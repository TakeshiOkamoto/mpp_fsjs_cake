<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FsjsJournal Entity
 *
 * @property int $id
 * @property int $yyyy
 * @property int $mm
 * @property int $dd
 * @property int $debit_account_id
 * @property int $credit_account_id
 * @property int $money
 * @property string $summary
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $updated_at
 *
 * @property \App\Model\Entity\DebitAccount $debit_account
 * @property \App\Model\Entity\CreditAccount $credit_account
 */
class FsjsJournal extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'yyyy' => true,
        'mm' => true,
        'dd' => true,
        'debit_account_id' => true,
        'credit_account_id' => true,
        'money' => true,
        'summary' => true,
        
        // 'created_at' => true,
        // 'updated_at' => true,
    ];
}
