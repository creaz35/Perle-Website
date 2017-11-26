<?php
namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Email\Email;
use Cake\Network\Exception\NotFoundException;
use Cake\Validation\Validator;

class PerlesController extends AppController
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
    }

    public function suggest()
    
    {
    	$this->loadModel('Perles');

    	 //A suggestion has been posted.
        if ($this->request->is('post')) {
            //Check if the user is connected.
            if (!$this->Auth->user()) {
                return $this->Flash->error('You must be connected to suggest a perle.');
            }
            $this->request->data['user_id'] = $this->Auth->user('id');

            $newSuggestion = $this->Perles->newEntity($this->request->data, ['validate' => 'suggest']);

            if ($insertPerle = $this->Perles->save($newSuggestion)) {
                $this->Flash->success('Your comment has been posted successfully !');
                //Redirect the user to the same page.
                $this->redirect([
                    'action' => 'index'
                ]);
            }

        }


    }

}

