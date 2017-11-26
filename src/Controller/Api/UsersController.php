<?php
namespace App\Controller\Api;

use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\I18n\Time;
use Cake\Network\Email\Email;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Validation\Validator;
use App\Event\Notifications;
use Intervention\Image\ImageManager;
use Cake\Log\Log;

class UsersController extends AppController
{

    /**
     * Components.
     *
     * @var array
     */
    public $components = [
        'FriendsComponent' => [
            'className' => 'App\Controller\Component\Users\FriendsComponent'
        ]
    ];

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add', 'token', 'info', 'login', 'edit', 'view', 'notifications', 'forgot_password', 'profile']);
    }

    /**
     * Create new user and return id plus JWT token
     */
    public function add()
    {
        $this->Crud->on('afterSave', function(Event $event) {
            if ($event->subject->created) {
                $this->set('data', [
                    'id' => $event->subject->entity->id,
                    'token' => JWT::encode(
                        [
                            'sub' => $event->subject->entity->id,
                            'exp' =>  time() + 604800
                        ],
                        Security::salt()
                    )
                ]);
                //Notification Events.
                $this->eventManager()->attach(new Notifications());
                $event = new Event('Model.Notifications.new', $this, [
                    'user_id' => $event->subject->entity->id,
                    'type' => 'bot'
                ]);
                $this->eventManager()->dispatch($event);
                $this->Crud->action()->config('serialize.data', 'data');
            }
        });
        return $this->Crud->execute();
    }

    /**
     * Return JWT token if posted user credentials pass FormAuthenticate
     */
    public function token()
    {
        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Email ou mot de passe invalide');
        }

        $this->set([
            'success' => true,
            'data' => [
                'token' => JWT::encode(
                    [
                        'sub' => $user['id'],
                        'exp' =>  time() + 604800
                    ],
                    Security::salt()
                ),
                'id' => $user['id']
            ],
            '_serialize' => ['success', 'data']
        ]);
    }

    public function info() {

        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Email ou mot de passe invalide');
        }

        $user_id = $user['id'];

        // Count number of perles said by the user
        $this->loadModel('Perles');

        $user_perles_count_said = $this->Perles
        ->find()
        ->where([
            'said_by_user_id' => $user_id
        ])
        ->count();

        // Custom
        $user['user_perles_count_said'] = $user_perles_count_said;
        $user['nbr_friends'] = $this->FriendsComponent->nbr_friends($user_id);
        $user['list_friends'] = $this->FriendsComponent->list_friends($user_id);
        //$check_friend = $this->FriendsComponent->check_friend(7,5);

        $this->set([
            'success' => true,
            'data' => [
                'user' => $user
            ],
            '_serialize' => ['success', 'data']
        ]);
    }

    /**
     * Display all notifications related to the user.
     *
     * @return void
     */
    public function notifications()
    {

        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Email ou mot de passe invalide');
        }

        if (isset($this->request->data['page'])) {
            $page = $this->request->data['page'];
        } else {
            $page = 1;
        }

        $this->loadModel('Notifications');

        $this->paginate = [
            'maxLimit' => 10,
            'page' => $page
        ];

        $notifications = $this->Notifications
            ->find()
            ->where([
                'user_id' => $user['id']
            ])
            ->order([
                'is_read' => 'ASC',
                'created' => 'DESC'
            ])
            ->find('map', [
                'session' => $this->request->session()
            ]);

        $notifications = $this->paginate($notifications);

        $this->set([
            'success' => true,
            'data' => [
                'notifications' => $notifications,
                'pagination' => $this->request->params['paging'],
                'page' => $page
            ],
            '_serialize' => ['success', 'data']
        ]);
    }

    public function view() {

        $me = $this->Auth->identify();
        if (!$me) {
            throw new UnauthorizedException('Email ou mot de passe invalide');
        }

        $userId = $this->request->data['userId'];

        // If it's my profile
        if ($userId == $me['id']) {

            $user_id = $this->request->data['userId'];
            $user = $me;
            
        } else {

            $q = $this->Users
            ->find()
            ->where([
                'Users.id' => $userId
            ])
            ->first();

            $user_id = $q->id;
            $user = $q->toArray();

        }

        // Count number of perles said by the user
        $this->loadModel('Perles');

        $user_perles_count_said = $this->Perles
        ->find()
        ->where([
            'said_by_user_id' => $user_id
        ])
        ->count();

        // Custom
        $user['user_perles_count_said'] = $user_perles_count_said;
        $user['nbr_friends'] = $this->FriendsComponent->nbr_friends($user_id);
        $user['list_friends'] = $this->FriendsComponent->list_friends($user_id);

        if ($userId == $me['id']) {
            $user['are_friends'] = '';
        } else {
            $user['are_friends'] = $this->FriendsComponent->check_friend($userId,$me['id']);
        }

        $this->set([
            'success' => true,
            'data' => [
                'user' => $user
            ],
            '_serialize' => ['success', 'data']
        ]);

    }

    public function edit() {

        $me = $this->Auth->identify();
        if (!$me) {
            throw new UnauthorizedException('Email ou mot de passe invalide');
        }

        $user = $this->Users->get($me['id']);
        //$user->email = '';
        //$user->first_name = '';

        // Save image
        if ((isset($this->request->data['me']['base_avatar'])) && $this->request->data['me']['base_avatar'] != '') { 
            $manager = new ImageManager();
            $base_64 = $this->request->data['me']['base_avatar'];
            $pos  = strpos($base_64, ';');
            $type = explode(':', substr($base_64, 0, $pos))[1];
            $img = str_replace('data:'. $type . ';base64,', '', $base_64);
            $img = str_replace(' ', '+', $img);
            $base_64 = base64_decode($img);
            $directory = 'img/avatars/' . rand(1,9999) . 'test.jpg';
            $path = $_SERVER['DOCUMENT_ROOT'] . 'webroot/' . $directory;
            $user->avatar = $directory;
        }

        $this->Users->patchEntity($user, $this->request->data['me'], ['validate' => 'settings']);

        if ($this->Users->save($user, ['validate' => 'settings'])) {

            if ((isset($this->request->data['me']['base_avatar'])) && $this->request->data['me']['base_avatar'] != '') { 
                // Save Image
                $image = $manager->make($base_64);
                $image->save($path);
            }

            $this->set([
                'success' => true,
                'data' => [
                    'user' => $user
                ],
                '_serialize' => ['success', 'data']
            ]);
        }

    }

    public function updatePassword() {

        $me = $this->Auth->identify();
        if (!$me) {
            throw new UnauthorizedException('Email ou mot de passe invalide');
        }

        // Get the current user
        $user = $this->Users
            ->find()
            ->where([
                'Users.id' => $me['id']
            ])
            ->first();

        $data = $this->request->data;
        if (!isset($data['old_password']) || !isset($data['password']) || !isset($data['password_confirm'])) {
            throw new UnauthorizedException('Remplissez tous les champs, s\'il vous plaît!');
        }
        if (!(new DefaultPasswordHasher)->check($data['old_password'], $user->password)) {
            throw new UnauthorizedException('Votre ancien mot de passe ne correspond pas!');
        }
        $this->Users->patchEntity($user, $this->request->data());
        if ($this->Users->save($user)) {
            $this->set([
                'success' => true,
                'data' => [
                    'user' => $user
                ],
                '_serialize' => ['success', 'data']
            ]);
        }
    }

    public function updateNotif() {

        $me = $this->Auth->identify();
        if (!$me) {
            throw new UnauthorizedException('Email ou mot de passe invalide');
        }

        $this->request->data[$this->request->data['notif']['field']] = $this->request->data['notif']['value'];

        // Get the current user
        $user = $this->Users
            ->find()
            ->where([
                'Users.id' => $me['id']
            ])
            ->first();

        $this->Users->patchEntity($user, $this->request->data());
        if ($this->Users->save($user)) {
            $this->set([
                'success' => true,
                'data' => [
                    'user' => $user
                ],
                '_serialize' => ['success', 'data']
            ]);
        }

    }

    public function friends() {

        $user = $this->Auth->identify();
        $json = array();
        if (!$user) {
            throw new UnauthorizedException('Email ou mot de passe invalide');
        }

        $keyword = strtolower($this->request->data['query']);

        $users = $this->Users
            ->find('all')   
            ->where([
                'OR' => [
                    'Users.first_name LIKE' => "%$keyword%",
                    'Users.last_name LIKE' => "%$keyword%",
                    "concat(Users.first_name , ' ' , Users.last_name) LIKE '$keyword%'"
                ]
            ]);
            
        $json['users'] = $users->toArray();

        // Set the view vars that have to be serialized.
        $this->set('json', $json);
        // Specify which view vars JsonView should serialize.
        $this->set('_serialize', ['json']);

    }

    public function forgot_password()
    {

        $user = $this->Users
            ->find()
            ->where([
                'Users.email' => $this->request->data['email']
            ])
            ->first();

        if (is_null($user)) {
           throw new UnauthorizedException('Invalid email');
        }

        //Generate the unique code
        $code = md5(rand() . uniqid() . time());
        //Update the user's information
        $user->password_code = $code;
        $user->password_code_expire = new Time();
        $this->Users->save($user);
        $viewVars = [
            'userId' => $user->id,
            'name' => $user->full_name,
            'username' => $user->username,
            'code' => $code
        ];
        
        $email = new Email();
        $email->profile('default')
        ->transport('amazon')
        ->template('forgotPassword', 'default')
        ->emailFormat('html')
        ->from(['brian.millot@gmail.com' => __('Forgot your Password - Xeta')])
        ->to('brian.millot@gmail.com')
        ->subject(__('Forgot your Password - Xeta'))
        ->viewVars($viewVars)
        ->send();

        $this->set([
            'success' => true,
            'data' => [
                'user' => $user,
                'message' => 'Mail sent!'
            ],
            '_serialize' => ['success', 'data']
        ]);

    }
}
