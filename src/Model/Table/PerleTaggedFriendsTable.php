<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class PerleTaggedFriendsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('perle_tagged_friends');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Perles', [
            'foreignKey' => 'perle_id'
        ]);
    }
}