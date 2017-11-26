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

class PerleCommentsController extends AppController
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
     * Index method
     *
     * @return void
     */
    public function index()
    {

        $perle_comments = $this->PerleComments
            ->find('all')
            ->contain([
                'Perles',
                'Users'
            ])
            ->order([
                'PerleComments.created' => 'DESC'
            ])->toArray();

        $this->set('perle_comments', $perle_comments);
        $this->set('_serialize', ['perle_comments']);
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
        $perle_comments = $this->PerleComments->get($id);
        $this->set('perle_comments', $perle_comments);
        $this->set('_serialize', ['perle_comments']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $perle_comment = $this->PerleComments->newEntity();
        if ($this->request->is('post')) {
            $perle_comment = $this->PerleComments->patchEntity($perle_comment, $this->request->data);
            if ($this->PerleComments->save($perle_comment)) {
                $this->Flash->success('The pearl has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The pearl could not be saved. Please, try again.');
            }
        }

        $this->loadModel('Users');
        $users = $this->Users->find('list');

        $this->loadModel('Perles');
        $perles = $this->Perles->find('list');

        $this->set(compact('perle_comment', 'perles', 'users'));
        $this->set('_serialize', ['perle_comment', 'perles', 'users']);
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
        $perle_comment = $this->PerleComments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $perle_comment = $this->PerleComments->patchEntity($perle_comment, $this->request->data);
            if ($this->PerleComments->save($perle_comment)) {
                $this->Flash->success('The perle_comments has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The perle_comments could not be saved. Please, try again.');
            }
        }

        $this->loadModel('Users');
        $users = $this->Users->find('list');

        $this->loadModel('Perles');
        $perles = $this->Perles->find('list');

        $this->set(compact('perle_comment', 'perles', 'users'));
        $this->set('_serialize', ['perle_comment', 'perles', 'users']);
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
        $perle_comments = $this->PerleComments->get($id);
        if ($this->PerleComments->delete($perle_comments)) {
            $this->Flash->success('The pearl has been deleted.');
        } else {
            $this->Flash->error('The pearl could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}