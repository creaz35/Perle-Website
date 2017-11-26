<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Routing\Router;

class AppController extends Controller {

    use \Crud\Controller\ControllerTrait;

    public $components = [
        'Crud.Crud' => [
            'actions' => [
                'Crud.Index',
                'Crud.View',
                'Crud.Add',
                'Crud.Edit',
                'Crud.Delete'
            ]
        ],
        'Flash',
        'Cookie',
            'Auth' => [
            'className' => 'Auth',
            'allowedActionsForBanned' => [
                'Pages' => [
                    'home'
                ]
            ],
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ],
                'ADmad/HybridAuth.HybridAuth' => [
                    // All keys shown below are defaults
                    'fields' => [
                        'provider' => 'provider',
                        'openid_identifier' => 'openid_identifier',
                        'email' => 'email'
                    ],

                    'profileModel' => 'ADmad/HybridAuth.SocialProfiles',
                    'profileModelFkField' => 'user_id',

                    'userModel' => 'Users',

                    // The URL Hybridauth lib should redirect to after authentication.
                    // If no value is specified you are redirect to this plugin's
                    // HybridAuthController::authenticated() which handles persisting
                    // user info to AuthComponent and redirection.
                    'hauth_return_to' => null
                ]
            ],
            'flash' => [
                'element' => 'error',
                'key' => 'flash',
                'params' => [
                    'class' => 'error'
                ]
            ],
            'authorize',
            'loginAction' => [
                'controller' => 'users',
                'action' => 'login',
                'prefix' => false
            ],
            'unauthorizedRedirect' => [
                'controller' => 'pages',
                'action' => 'home',
                'prefix' => false
            ],
            'loginRedirect' => [
                'controller' => 'pages',
                'action' => 'home',
                'plugin' => false
            ],
            'logoutRedirect' => [
                'controller' => 'pages',
                'action' => 'home'
            ],
            'authError' => 'You are not authorized to access that location !'
        ]
    ];

    /**
     * Helpers.
     *
     * @var array
     */
    public $helpers = [
        'Form' => [
            'templates' => [
                'error' => '<div class="text-danger">{{content}}</div>',
                'radioWrapper' => '{{input}}{{label}}',
                'nestingLabel' => '<label{{attrs}}>{{text}}</label>'
            ]
        ]
    ];

    /**
     * beforeFilter handle.
     *
     * @param Event $event The beforeFilter event that was fired.
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        //Set trustProxy or get the original visitor IP.
        $this->request->trustProxy = true;
        if (isset($this->request->params['prefix'])) {
            $prefix = explode('/', $this->request->params['prefix'])[0];
            switch($prefix) {
                case 'admin':

                  if ($this->Auth->user()) {
                    $this->viewBuilder()->layout('admin');
                    break;
                  } else {
                    echo 'not allowed';
                    die();
                  } 
            }
        }
    }
}