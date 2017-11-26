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
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('pages', $this->paginate($this->Pages));
        $this->set('_serialize', ['pages']);
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
        $page = $this->Pages->get($id);
        $this->set('page', $page);
        $this->set('_serialize', ['page']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $page = $this->Pages->newEntity();
        if ($this->request->is('post')) {
            $page = $this->Pages->patchEntity($page, $this->request->data);
            if ($this->Pages->save($page)) {
                $this->Flash->success('The pearl has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The pearl could not be saved. Please, try again.');
            }
        }
        $this->set(compact('page'));
        $this->set('_serialize', ['page']);
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
        $page = $this->Pages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $page = $this->Pages->patchEntity($page, $this->request->data);
            if ($this->Pages->save($page)) {
                $this->Flash->success('The page has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The page could not be saved. Please, try again.');
            }
        }
        $this->set(compact('page'));
        $this->set('_serialize', ['page']);
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
        $page = $this->Pages->get($id);
        if ($this->Pages->delete($page)) {
            $this->Flash->success('The pearl has been deleted.');
        } else {
            $this->Flash->error('The pearl could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}