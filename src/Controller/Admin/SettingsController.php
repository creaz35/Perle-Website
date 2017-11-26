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

class SettingsController extends AppController
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
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function index($id = 1)
    {
        $settings = $this->Settings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $settings = $this->Settings->patchEntity($settings, $this->request->data);
            if ($this->Settings->save($settings)) {
                $this->Flash->success('The settings has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The settings could not be saved. Please, try again.');
            }
        }

        $choices = ['0' => 'Non', '1' => 'Oui'];

        $this->set(compact('settings', 'choices'));
        $this->set('_serialize', ['settings', 'choices']);
    }
}