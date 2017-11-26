<?php
namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Email\Email;
use Intervention\Image\ImageManagerStatic as InterventionImage;
use Phinx\Migration\AbstractMigration;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{


    // configure with favored image driver (gd by default)
    //InterventionImage::configure(array('driver' => 'gd'));
    // and you are ready to go ...
    //$image = InterventionImage::make('public/foo.jpg')->resize(300, 200);

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
        $this->Auth->allow(['register', 'login', 'resetPassword']);
    }

    /**
     * Login and register page.
     *
     * @return \Cake\Network\Response|void
     */
    public function login()
    {

        if ($this->request->is('post')) {
            $userLogin = $this->Auth->identify();
            if ($userLogin) {
                $this->Auth->setUser($userLogin);
                $user = $this->Users->newEntity($userLogin);
                $user->isNew(false);
                $user->last_login = new Time();
                $user->last_login_ip = $this->request->clientIp();
                $this->Users->save($user);
                //Cookies.
                $this->Cookie->configKey('CookieAuth', [
                    'expires' => '+1 year',
                    'httpOnly' => true
                ]);
                $this->Cookie->write('CookieAuth', [
                    'email' => $this->request->data('email'),
                    'password' => $this->request->data('password')
                ]);
                $url = $this->Auth->redirectUrl();
                if (substr($this->Auth->redirectUrl(), -5) == 'login') {
                    $url = ['controller' => 'pages', 'action' => 'home'];
                }
                return $this->redirect($url);
            }
            $this->Flash->error('Votre e-mail ou mot de passe ne correspond pas.'); 
        } else {
            //Save the referer URL before the user send the login/register request else it will delete the referer.
            $this->request->session()->write('Auth.redirect', $this->referer());
        }
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
    }

	/**
     * Login and register page.
     *
     * @return \Cake\Network\Response|void
     */
    public function register()
    {

        $userRegister = $this->Users->newEntity($this->request->data);
        if ($this->request->is('post')) {
            $userRegister->register_ip = $this->request->clientIp();
            $userRegister->last_login_ip = $this->request->clientIp();
            $userRegister->last_login = new Time();
                if ($this->Users->save($userRegister)) {
                    $user = $this->Auth->identify();
                    if ($user) {
                        $this->Auth->setUser($user);
                    }
                    $user = $this->Users->get($user['id']);
                    // Email
                    $email = new Email();
                    $email->profile('default')
                        ->transport('amazon')
                        ->template('register', 'default')
                        ->emailFormat('html')
                        ->from(['contact@perle.io' => 'Perle'])
                        ->to($user->email)
                        ->subject('Bienvenue sur Perle!')
                        ->viewVars($viewVars)
                        ->send();
                    $this->Flash->success('Votre compte a été créé avec succès!');
                    $url = $this->Auth->redirectUrl();
                    if (substr($this->Auth->redirectUrl(), -5) == 'login') {
                        $url = ['controller' => 'pages', 'action' => 'home'];
                    }
                    return $this->redirect($url);
                }
                $this->Flash->error('S\'il vous plaît, corriger votre erreur.');
        } else {
            //Save the referer URL before the user send the login/register request else it will delete the referer.
            $this->request->session()->write('Auth.redirect', $this->referer());
        }
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        $this->set(compact('userRegister'));
    }

    /**
     * Logout an user.
     *
     * @return \Cake\Network\Response
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Display the form to reset his password.
     *
     * @return \Cake\Network\Response|void
     */
    public function resetPassword()
    {

        //Prevent for empty code.
        if (empty(trim($this->request->code))) {
            $this->Flash->error(__("This code is not associated with this users or is incorrect."));
            return $this->redirect(['controller' => 'pages', 'action' => 'home']);
        }
        $user = $this->Users
            ->find()
            ->where([
                'Users.password_code' => $this->request->code,
                'Users.id' => $this->request->id
            ])
            ->first();
        if (is_null($user)) {
            $this->Flash->error(__("This code is not associated with this users or is incorrect."));
            return $this->redirect(['controller' => 'pages', 'action' => 'home']);
        }
        $expire = $user->password_code_expire->timestamp + (Configure::read('User.ResetPassword.expire_code') * 60);
        if ($expire < time()) {
            $this->Flash->error(__("This code is expired, please ask another E-mail code."));
            return $this->redirect(['action' => 'forgotPassword']);
        }
        if ($this->request->is(['post', 'put'])) {
            $this->Users->patchEntity($user, $this->request->data, ['validate' => 'resetpassword']);
            if ($this->Users->save($user)) {
                $this->Flash->success(__("Your password has been changed !"));
                //Reset the code and the time.
                $user->password_code = '';
                $user->password_code_expire = new Time();
                $user->password_reset_count = $user->password_reset_count + 1;
                $this->Users->save($user);
                return $this->redirect(['controller' => 'pages', 'action' => 'home']);
            }
        }

        $this->set(compact('user'));
    }

}
