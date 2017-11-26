<?php
namespace App\Controller\Component\Users;
use Cake\Controller\Component;
use Cake\Controller\Component\PaginatorComponent;

class FriendsComponent extends Component
{
    
    /**
     * Request object
     *
     * @var \Cake\Network\Request
     */
    protected $_request;
    /**
     * Instance of the Session object
     *
     * @return void
     */
    protected $_session;
    /**
     * Instance of the Controller object
     *
     * @return void
     */
    protected $_controller;

    public $components = ['Paginator'];

    /**
     * Initialize properties.
     *
     * @param array $config The config data.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        $controller = $this->_registry->getController();
        $this->_controller = $controller;
        $this->_request = $controller->request;
        $this->_session = $controller->request->session();
    }

    /**
     * Check if the user is friend to the other user.
     */
    public function check_friend($a, $b)
    {
        
        $this->_controller->loadModel('UserFriends');

        $checkFriend = $this->_controller->UserFriends->find('all') 
        ->where('(UserFriends.receiver_id = ' . $a . ' AND UserFriends.sender_id = ' . $b . ') OR (UserFriends.receiver_id = ' . $b . ' AND UserFriends.sender_id = ' . $a . ')');

        $countCheckFriend = $checkFriend->count();
        $rowCheckFriend = $checkFriend->first();

        $array = array();

        // If asked
        if ($countCheckFriend == 1) {
            $array['friend'] = $rowCheckFriend->friend;
            $array['validated_date'] = $rowCheckFriend->validated_date;
            if ($array['friend'] == 1)
                $array['text'] = 'Déjà amis';
            else
                $array['text'] = 'Demande envoyer!';
            return $array;
        // If not asked
        } else {
            $array['text'] = 'Ajouter an amis!';
            return $array;
        }

    }

    /**
     * Get number of friends of the user.
     */
    public function nbr_friends($user_id)
    {

        $this->_controller->loadModel('UserFriends');

        $CountFriends = $this->_controller->UserFriends->find('all') 
        ->where('(UserFriends.receiver_id = ' . $user_id . ' AND UserFriends.friend = ' . 1 . ') OR (UserFriends.sender_id = ' . $user_id . ' AND UserFriends.friend = ' . 1 . ')')->count();
        
        return $CountFriends;

    }

    /**
     * Get the list of friends.
     */
    public function list_friends($user_id, $limit = null, $keyword = null)
    {

        $this->_controller->loadModel('UserFriends');
        $this->_controller->loadModel('Users');

        $friends = $this->_controller->UserFriends
            ->find()
            ->where([
                'OR' => [['UserFriends.sender_id' => $user_id], ['UserFriends.receiver_id' => $user_id]],
                ['friend' => 1]
            ]);

        if ($limit != '') {
            $friends = $this->Paginator->paginate($friends, ['maxLimit' => $limit]);
        } else {
            $friends = $this->Paginator->paginate($friends);
        }

        $friendsArray = $friends->toArray();
        $friendsCount = $friends->count();

        if ($friendsCount >= 1) { 
            $friendsList = array();

            foreach($friendsArray as $k => $v) {

                if ($v->receiver_id != $user_id)
                    $v->user_id = $v->receiver_id;
                else if ($v->sender_id != $user_id)
                    $v->user_id = $v->sender_id;

                $user = $this->_controller->Users
                ->find()
                ->where([
                    'OR' => [
                        'Users.first_name LIKE' => "%$keyword%",
                        'Users.last_name LIKE' => "%$keyword%",
                        "concat(Users.first_name , ' ' , Users.last_name) LIKE '$keyword%'"
                    ],
                    ['Users.id' => $v->user_id]
                ])
                ->first();

                if (is_null($user) || $user->is_deleted == true) {
                    unset($friendsArray[$k]);
                } else {
                    $user['validated_date'] = $v->validated_date;
                    $user['line_id'] = $v->id;
                    $friendsList[] = $user;
                }

            }
            
            return $friendsList;

        } else {
            return null;
        }

    }

    public function count_invitations($user_id) {

        $this->_controller->loadModel('UserFriends');

        $count_invitations = $this->_controller->UserFriends
        ->find()
        ->where([
            ['UserFriends.receiver_id' => $user_id],
            ['friend' => 0]
        ])->count();

        return $count_invitations;

    }

    /**
     * Invitations sent
     */
    public function invitations($user_id, $limit = null) {

        $this->_controller->loadModel('UserFriends');
        $this->_controller->loadModel('Users');

        $invitations = $this->_controller->UserFriends
        ->find()
        ->where([
            ['UserFriends.receiver_id' => $user_id],
            ['friend' => 0]
        ]);

        $invitationsCount = $invitations->count();

        if ($limit != '') {
            $invitations = $this->Paginator->paginate($invitations, ['maxLimit' => $limit]);
        } else {
            $invitations = $this->Paginator->paginate($invitations);
        }

        $invitationsArray = $invitations->toArray();

        if ($invitationsCount >= 1) { 
            $invitationsList = array();

            foreach($invitationsArray as $k => $v) {

                $v->user_id = $v->sender_id;
                
                $user = $this->_controller->Users
                ->find()
                ->where([
                    'Users.id' => $v->user_id
                ])
                ->first();

                if (is_null($user)) {
                    unset($invitations[$k]);
                } else {
                    $invitationsList[] = $user;
                }

            }
            
            return $invitationsList;

        } else {
            return null;
        }

    }

    public function count_asked($user_id) {

        $this->_controller->loadModel('UserFriends');
        
        $count_asked = $this->_controller->UserFriends
        ->find()
        ->where([
            ['UserFriends.sender_id' => $user_id],
            ['friend' => 0]
        ])->count();

        return $count_asked;

    }

    /**
     * Frienship asked.
     */
    public function asked($user_id, $limit = null) {

        $this->_controller->loadModel('UserFriends');
        $this->_controller->loadModel('Users');

        $asked_friends = $this->_controller->UserFriends
        ->find()
        ->where([
            ['UserFriends.sender_id' => $user_id],
            ['friend' => 0]
        ]);

        $askedFriendsCount = $asked_friends->count();

        if ($limit != '') {
            $asked_friends = $this->Paginator->paginate($asked_friends, ['maxLimit' => $limit]);
        } else {
            $asked_friends = $this->Paginator->paginate($asked_friends);
        }

        $askedFriendsArray = $asked_friends->toArray();

        if ($askedFriendsCount >= 1) { 
            $askedFriendsList = array();

            foreach($askedFriendsArray as $k => $v) {

                $v->user_id = $v->receiver_id;

                $user = $this->_controller->Users
                ->find()
                ->where([
                    'Users.id' => $v->user_id
                ])
                ->first();

                if (is_null($user) || $user->is_deleted == true) {
                    unset($asked_friends[$k]);
                } else {
                    $askedFriendsList[] = $user;
                }

            }
            
            return $askedFriendsList;

        } else {
            return null;
        }

    }
}