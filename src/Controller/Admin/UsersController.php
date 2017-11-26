<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\I18n\Number;
use Mexitek\PHPColors\Color;
use Widop\HttpAdapter\CurlHttpAdapter;
use Cake\Network\Exception\NotFoundException;
use Cake\Routing\Router;

class UsersController extends AppController
{

    /**
     * Components.
     *
     * @var array
     */
    public $components = [
        'RequestHandler',
        'FriendsComponent' => [
            'className' => 'App\Controller\Component\Users\FriendsComponent'
        ]
    ];

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('users', $this->paginate($this->Users));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success('The user has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The user could not be saved. Please, try again.');
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

                    $this->loadModel('UserFriends');

            $this->request->data['friend'] = 0;
            $this->request->data['sender_id'] = 2;
            $this->request->data['receiver_id'] = 55;

            $user_friend = $this->UserFriends->newEntity();

            //if ($this->request->is('post','put')) {

                $user_friend = $this->UserFriends->patchEntity($user_friend,$this->request->data);

                if ($this->UserFriends->save($user_friend)) {
                    
                }
           // }

        // LIST OF FRIENDS
        $list_friends = $this->FriendsComponent->list_friends(5);

        // NBR OF FRIENDS
        $nbr_friends = $this->FriendsComponent->nbr_friends(5);

        // IF THE USERS ARE FRIENDS
        $check_friend = $this->FriendsComponent->check_friend(7,5);
        echo $check_friend;
        die();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success('The user has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The user could not be saved. Please, try again.');
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success('The user has been deleted.');
        } else {
            $this->Flash->error('The user could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}