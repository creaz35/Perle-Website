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

class LoginController extends AppController
{

    /**
     * Components.
     *
     * @var array
     */
    public $components = [
        'RequestHandler'
    ];

    public function index() {

        $this->viewBuilder()->layout('login');
        
    }
}