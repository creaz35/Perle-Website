<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class PagesTable extends Table
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
        $this->table('pages');
        $this->displayField('content');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
    }
}