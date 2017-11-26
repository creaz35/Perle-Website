<?php
namespace App\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PerleCommentsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('perle_comments');
        $this->displayField('content');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        
        $this->addBehavior('CounterCache', [
            'Perles' => ['comment_count']
        ]);

        $this->belongsTo('Perles', [
            'foreignKey' => 'perle_id',
        ]);
        
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
    }
}
