<?php
namespace App\Model\Entity;

use App\Model\Behavior\AppTranslateTrait;
use Cake\Core\Configure;
use Cake\I18n\Number;
use Cake\ORM\Behavior\Translate\TranslateTrait;
use Cake\ORM\Entity;
use HTMLPurifier;
use HTMLPurifier_Config;

class PerleTaggedFriend extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true
    ];

}