<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PerlesTable extends Table
{

    /**
     * Initialize method.
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('perles');
        $this->displayField('content');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('CounterCache', [
            'Users' => ['perles_count']
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);

        $this->hasMany('PerleComments', [
            'foreignKey' => 'perle_id',
            'dependent' => true
        ]);

        $this->hasMany('PerleTaggedFriends', [
            'foreignKey' => 'perle_id',
            'dependent' => true
        ]);
    }

        /**
     * Settings validation rules.
     *
     * @param \Cake\Validation\Validator $validator The Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationSuggest(Validator $validator)
    {
        return $validator
            ->notEmpty('content', __("Your E-mail can not be empty."));
    }
}
