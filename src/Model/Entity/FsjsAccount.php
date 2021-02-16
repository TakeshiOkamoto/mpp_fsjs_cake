<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FsjsAccount Entity
 *
 * @property int $id
 * @property string $name
 * @property int $types
 * @property bool $expense_flg
 * @property int $sort_list
 * @property int $sort_expense
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $updated_at
 */
class FsjsAccount extends Entity
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
        'name' => true,
        'types' => true,
        'expense_flg' => true,
        'sort_list' => true,
        'sort_expense' => true,

        // 'created_at' => true,
        // 'updated_at' => true,
    ];
}
