<?php
namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Email\Email;
use Cake\Network\Exception\NotFoundException;
use Cake\Validation\Validator;

class PagesController extends AppController
{

	/**
     * Components.
     *
     * @var array
     */
    public $components = [
        'RequestHandler'
    ];

    /**
     * Beforefilter.
     *
     * @param Event $event The beforeFilter event that was fired.
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['home', 'sendEmail', 'test', 'legals', 'cgu']);
    }

    public function home()
    
    {

    }

    public function test() {

    }

    /**
     * Contact.
     *
     * @return \Cake\Network\Response|void
     */
    public function sendEmail()
    {

    	if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $json = [
            'error' => false
        ];

        $contact = [
            'schema' => [
                'full_name' => [
                    'type' => 'string',
                    'length' => 100
                ],
                'email' => [
                    'type' => 'string',
                    'length' => 100
                ],
                'message' => [
                    'type' => 'string'
                ]
            ],
            'required' => [
                'full_name' => 1,
                'email' => 1,
                'message' => 1
            ]
        ];
        if ($this->request->is('post')) {
            $validator = new Validator();
            $validator
                ->notEmpty('email', 'Vous devez specifier votre addresse e-mail!')
                ->notEmpty('full_name', 'Vous devez specifier votre anom!')
                ->notEmpty('message', 'Vous devez specifier votre message!');
            $contact['errors'] = $validator->errors($this->request->data());
            if (empty($contact['errors'])) {
                $viewVars = [
                    'ip' => $this->request->clientIp()
                ];
                $viewVars = array_merge($this->request->data(), $viewVars);
                $email = new Email();
                $email->profile('default')
                	->transport('amazon')
                    ->template('contact', 'default')
                    ->emailFormat('html')
                    ->from(['contact@perle.io' => 'Perle'])
                    ->to('contact@perle.io')
                    ->subject('[Perle - Site] Formulaire de contact')
                    ->viewVars($viewVars)
                    ->send();

                $json['error'] = false;
	            $this->set(compact('json'));
	            $this->set('_serialize', 'json');
	            return;

            } else {

            	$json['error'] = true;
            	$json['errors'] = $contact['errors'];
	            $this->set(compact('json'));
	            $this->set('_serialize', 'json');
	            return;
            }
        }
        
        $this->set(compact('json'));
        $this->set('_serialize', ['json']);

    }

    public function legals() {

    }

    public function cgu() { }

}
