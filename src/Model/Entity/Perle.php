<?php
namespace App\Model\Entity;

use App\Model\Behavior\AppTranslateTrait;
use Cake\Core\Configure;
use Cake\I18n\Number;
use Cake\ORM\Behavior\Translate\TranslateTrait;
use Cake\ORM\Entity;
use HTMLPurifier;
use HTMLPurifier_Config;
use Cake\ORM\TableRegistry;

class Perle extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true
    ];

    protected function _getLiked()
    {
        if (!$this->id) {
            return null;
        }
        
        $PerlesLikes = TableRegistry::get('PerlesLikes');
        $liked = $PerlesLikes->find('all', ['fields' => ['id']])->where(['perle_id' => $this->id, 'user_id' => $this->user_id]);

        if($liked->count() == 0)
        	return 0;

        return 1;
    }

    protected function _getDisliked()
    {
        if (!$this->id) {
            return null;
        }
        
        $PerlesDisLikes = TableRegistry::get('PerlesDisLikes');
        $disliked = $PerlesDisLikes->find('all', ['fields' => ['id']])->where(['perle_id' => $this->id, 'user_id' => $this->user_id]);

        if($disliked->count() == 0)
        	return 0;

        return 1;
    }

}