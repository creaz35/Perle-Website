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

class NotificationsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['count_unread']);
    }

    /**
     * Create new user and return id plus JWT token
     */
    public function count_unread()
    {
        
        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Email ou mot de passe invalide');
        }

        // Count number of unread 
        $this->loadModel('Notifications');

        $count_unread = $this->Notifications
        ->find()
        ->where([
            'Notifications.user_id' => $user['id']
        ])
        ->count();

        $this->set([
            'success' => true,
            'data' => [
                'count_unread' => $count_unread
            ],
            '_serialize' => ['success', 'data']
        ]);

    }
}
