<?php
namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\ORM\TableRegistry;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Email\Email;
use Cake\View\Helper\PaginatorHelper;


class SettingsController extends AppController
{

    public function initialize()
    {
        parent::initialize();

    }

    public function pages() {

        $this->loadModel('Pages');

        $pages = $this->Pages->find('all')->toArray();
        $this->set([
            'success' => true,
            'data' => [
                'pages' => $pages
            ],
            '_serialize' => ['success', 'data']
        ]);
    }

    public function getPage() {
        
        $this->loadModel('Pages');

        $page = $this->Pages
            ->find()
            ->where([
                'Pages.id' => $this->request->data['page_id']
            ])
            ->first();

        $this->set([
            'success' => true,
            'data' => [
                'page' => $page
            ],
            '_serialize' => ['success', 'data']
        ]);
    }

    public function options() {

        $this->loadModel('Settings');

        $pages = $this->Settings->find('all')->toArray();
        $this->set([
            'success' => true,
            'data' => [
                'settings' => $settings
            ],
            '_serialize' => ['success', 'data']
        ]);
    }
}