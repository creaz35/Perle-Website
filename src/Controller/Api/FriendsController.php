<?php
namespace App\Controller\Api;

use Cake\Event\Event;
use App\Event\Notifications;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\I18n\Time;
use Cake\Network\Email\Email;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Validation\Validator;

class FriendsController extends AppController
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
        $this->Auth->allow(['searchFriend']);

    }

    public function add() {

        $user = $this->Auth->identify();
        $json = array();

        if (!$user) {
            throw new UnauthorizedException('Invalid email or password');
        }

        if ($this->request->data['userId'] == $user['id']) {
            throw new UnauthorizedException('You cannot be friend with yourself!');
        }

        // Check if the logged user and the user are friends first
        $are_friends = $this->FriendsComponent->check_friend($user['id'], $this->request->data['userId']);

        if (isset($are_friends['friend'])) {
            if($are_friends['friend'] == 1) {
                throw new UnauthorizedException('Deja amis...');
            } else {
                throw new UnauthorizedException('Demande deja Envoyer!');
            }
        } else {

            $this->loadModel('UserFriends');

            $this->request->data['friend'] = 0;
            $this->request->data['sender_id'] = $user['id'];
            $this->request->data['receiver_id'] = $this->request->data['userId'];

            $user_friend = $this->UserFriends->newEntity();

            if ($this->request->is('post','put')) {

                $user_friend = $this->UserFriends->patchEntity($user_friend,$this->request->data);

                if ($this->UserFriends->save($user_friend)) {
                    $this->set([
                        'success' => true,
                        'data' => [
                            'user_friend' => $user_friend
                        ],
                        '_serialize' => ['success', 'data']
                    ]);
                }
            }

        }

    }

    public function delete() {

        $user = $this->Auth->identify();
        $json = array();
        if (!$user) {
            throw new UnauthorizedException('Email ou mot de passe invalide');
        }

        $friendId = $this->request->data['friendId'];

        //Check if the data exist.
        $this->loadModel('UserFriends');
        $friend = $this->UserFriends
            ->find()
            ->where([
                'UserFriends.id' => $friendId
            ])
            ->first();

        if (empty($friend)) {
            throw new UnauthorizedException('This user doesn\'t exist or has been deleted.');
        }

        if ($this->UserFriends->delete($friend)) {
            $this->set([
                'success' => true,
                'data' => [
                    'friend' => $friend
                ],
                '_serialize' => ['success', 'data']
            ]);
        } else {
            throw new UnauthorizedException('This friend cannot be deleted.');
        }


    }

    public function acceptInvit() {


        $me = $this->Auth->identify();
        if (!$me) {
            throw new UnauthorizedException('Email ou mot de passe invalide');
        }

        //Check if the data exist.
        $friendId = $this->request->data['friendId'];

        $this->loadModel('UserFriends');
        $invitation = $this->UserFriends
            ->find()
            ->where([
                'UserFriends.id' => $friendId
            ])
            ->first();

        if (empty($invitation)) {
            throw new UnauthorizedException('This user doesn\'t exist or has been deleted.');
        }

        $invitation->validated_date = new Time();
        $invitation->friend = 1;

        $this->UserFriends->patchEntity($invitation, $this->request->data());

        if ($this->UserFriends->save($invitation)) {
            $this->set([
                'success' => true,
                'data' => [
                    'invitation' => $invitation
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

        $this->loadModel('Users');
        $keyword = strtolower($this->request->data['query']);
        $json['users'] = $this->FriendsComponent->list_friends($user['id'], '', $keyword);

        // Set the view vars that have to be serialized.
        $this->set('json', $json);
        // Specify which view vars JsonView should serialize.
        $this->set('_serialize', ['json']);

    }

    public function recent() {

        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Email ou mot de passe invalide');
        }

        // Last 5 friends
        $recent_friends = $this->FriendsComponent->list_friends($user['id'], 5);

        $this->set([
            'success' => true,
            'data' => [
                'recent_friends' => $recent_friends
            ],
            '_serialize' => ['success', 'data']
        ]);

    }

    public function getAskedFriends() {

        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Email ou mot de passe invalide');
        }

        // Asked Friends
        $asked_friends = $this->FriendsComponent->asked($user['id']);
        // Count Asked Friends
        $count_asked_friends = $this->FriendsComponent->count_asked($user['id']);

        $this->set([
            'success' => true,
            'data' => [
                'asked_friends' => $asked_friends,
                'count' => $count_asked_friends
            ],
            '_serialize' => ['success', 'data']
        ]);

    }

    public function getInvitationsFriends() {

        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Email ou mot de passe invalide');
        }

        // Asked Friends
        $invitations = $this->FriendsComponent->invitations($user['id']);

        $this->set([
            'success' => true,
            'data' => [
                'invitations' => $invitations
            ],
            '_serialize' => ['success', 'data']
        ]);

    }

    public function count() {

        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Email ou mot de passe invalide');
        }

        // Count Asked Friends
        $count_invitations = $this->FriendsComponent->count_invitations($user['id']);
        $count_asked_friends = $this->FriendsComponent->count_asked($user['id']);

        $this->set([
            'success' => true,
            'data' => [
                'count_asked_friends' => $count_asked_friends,
                'count_invitations' => $count_invitations
            ],
            '_serialize' => ['success', 'data']
        ]);

    }
}