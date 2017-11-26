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
     * Index method
     *
     * @return void
     */
    public function index()
    {

        $perles = $this->Perles
            ->find('all')
            ->contain([
                'Users',
                'PerleTaggedFriends.Users'
            ])
            ->order([
                'Perles.created' => 'DESC'
            ])->toArray();

        $this->set('perles', $perles);
        $this->set('_serialize', ['perles']);
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
        $perle = $this->Perles->get($id);
        $this->set('perle', $perle);
        $this->set('_serialize', ['perle']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $perle = $this->Perles->newEntity();
        if ($this->request->is('post')) {
            $perle = $this->Perles->patchEntity($perle, $this->request->data);
            if ($this->Perles->save($perle)) {
                $this->Flash->success('The pearl has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The pearl could not be saved. Please, try again.');
            }
        }
        $this->set(compact('perle'));
        $this->set('_serialize', ['perle']);
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
        $perle = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $perle = $this->Users->patchEntity($perle, $this->request->data);
            if ($this->Users->save($perle)) {
                $this->Flash->success('The perle has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The perle could not be saved. Please, try again.');
            }
        }
        $this->set(compact('perle'));
        $this->set('_serialize', ['perle']);
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
        $perle = $this->Perles->get($id);
        if ($this->Perles->delete($perle)) {
            $this->Flash->success('The pearl has been deleted.');
        } else {
            $this->Flash->error('The pearl could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}