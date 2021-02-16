<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FsjsCapital Entity
 *
 * @property int $id
 * @property int $yyyy
 * @property int $m1
 * @property int $m2
 * @property int $m3
 * @property int $m4
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $updated_at
 */
class FsjsCapital extends Entity
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
        'm1' => true,
        'm2' => true,
        'm3' => true,
        'm4' => true,

        // 'created_at' => true,
        // 'updated_at' => true,
    ];
}
