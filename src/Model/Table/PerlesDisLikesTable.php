<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PerlesDisLikesTable extends Table
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
        $this->table('perles_dislikes');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('CounterCache', [
            'Perles' => ['dislike_count']
        ]);

        $this->belongsTo('Perles', [
            'foreignKey' => 'perle_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Instance of the validator.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('perle_id')
            ->add('perle_id', 'numeric', [
                'rule' => 'numeric'
            ])
            ->notEmpty('user_id')
            ->add('user_id', 'numeric', [
                'rule' => 'numeric'
            ]);

        return $validator;
    }
}
