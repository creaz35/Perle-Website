<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
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
        $this->table('users');
        $this->displayField('email');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->hasMany('Perles', [
            'foreignKey' => 'user_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasMany('PerleComments', [
            'foreignKey' => 'user_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasMany('PerleTaggedFriends', [
            'foreignKey' => 'user_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        // Hybrid Auth
        $this->hasMany('ADmad/HybridAuth.SocialProfiles');
        \Cake\Event\EventManager::instance()->on('HybridAuth.newUser', [$this, 'createUser']);
    }

    public function createUser(\Cake\Event\Event $event) {
    // Entity representing record in social_profiles table
    $profile = $event->data()['profile'];

    $user = $this->newEntity(['email' => $profile->email]);
    $user = $this->save($user);

    if (!$user) {
        throw new \RuntimeException('Unable to save new user');
    }

    return $user;
}

        /**
     * Create validation rules.
     *
     * @param \Cake\Validation\Validator $validator The Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('first_name', 'Vous devez indiquer votre prenom.')
            ->notEmpty('last_name', 'Vous devez indiquer votre nom de famille.')
            ->notEmpty('password', 'Vous devez indiquer votre mot de passe.')
            ->notEmpty('password_confirm', 'Vous devez indiquer votre mot de passe (Confirmation).')
            ->add('password_confirm', [
                'lengthBetween' => [
                    'rule' => ['lengthBetween', 4, 20],
                    'message' => "Votre mot de passe (confirmation) doit être comprise entre 4 et 20 caractères."
                ],
                'equalToPassword' => [
                    'rule' => function ($value, $context) {
                        return $value === $context['data']['password'];
                    },
                    'message' => 'Votre mot de passe doit correspondre à la confirmation du mot de passe.'
                ]
            ])
            ->notEmpty('email', 'Vous devez indiquer votre email.')
            ->add('email', [
                'unique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => 'Cet e-mail est déjà prise.'
                ],
                'email' => [
                    'rule' => 'email',
                    'message' => 'Vous devez spécifier une adresse e-mail valide.'
                ]
            ]);
        return $validator;
    }

    /**
     * ResetPassword validation rules.
     *
     * @param \Cake\Validation\Validator $validator The Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationResetpassword(Validator $validator)
    {
        return $validator
            ->notEmpty('password', __("You must specify your new password."))
            ->notEmpty('password_confirm', __("You must specify your password (confirmation)."))
            ->add('password_confirm', [
                'lengthBetween' => [
                    'rule' => ['lengthBetween', 8, 20],
                    'message' => __("Your password (confirmation) must be between {0} and {1} characters.", 8, 20)
                ],
                'equalToPassword' => [
                    'rule' => function ($value, $context) {
                            return $value === $context['data']['password'];
                    },
                    'message' => __("Your password confirm must match with your new password")
                ]
            ]);
    }

    /**
     * Settings validation rules.
     *
     * @param \Cake\Validation\Validator $validator The Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationSettings(Validator $validator)
    {
        return $validator
            ->notEmpty('email', __("Your E-mail can not be empty."))
            ->add('email', [
                'email' => [
                    'rule' => 'email',
                    'message' => __("You must specify a valid E-mail address.")
                ],
                'unique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => __("This E-mail is already used, please choose another E-mail.")
                ],
            ]);
    }

     /**
     * Account validation rules.
     *
     * @param \Cake\Validation\Validator $validator The Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationAccount(Validator $validator)
    {
        $validator
            ->notEmpty('first_name', "You must specify your first_name.");
        return $validator;
    }
}
