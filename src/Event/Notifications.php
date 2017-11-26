<?php
namespace App\Event;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;
class Notifications implements EventListenerInterface
{
    /**
     * ImplementedEvents method.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'Model.Notifications.new' => 'newNotification',
            'Model.Notifications.perle.comment' => '_perleComment'
        ];
    }
    /**
     * We send a new notification to an user.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return false
     */
    public function newNotification(Event $event)
    {
        $this->Notifications = TableRegistry::get('Notifications');
        if (!isset($event->data['type'])) {
            return false;
        }
        $event->data['type'] = strtolower($event->data['type']);
        switch ($event->data['type']) {
            case 'perle.comment':
                $result = $this->_perleComment($event);
                break;
            case 'perle.said':
                $result = $this->_perleSaid($event);
                break;
            case 'perle.tagFriends':
                $result = $this->perleLike($event);
                break;
            case 'perle.like':
                $result = $this->perleLike($event);
                break;
            case 'bot':
                $result = $this->_bot($event);
                break;
            default:
                $result = false;
        }
        return $result;
    }

    /**
     * A user has posted a comment to a perle.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return bool
     */
    protected function _perleComment(Event $event)
    {

        if (!is_integer($event->data['comment_id'])) {
            return false;
        }

        $this->Perles = TableRegistry::get('Perles');
        $this->PerleComments = TableRegistry::get('PerleComments');
        $this->Users = TableRegistry::get('Users');

        $comment = $this->PerleComments
            ->find()
            ->where([
                'PerleComments.id' => $event->data['comment_id']
            ])
            ->select([
                'id', 'user_id'
            ])
            ->first();

        $sender = $this->Users
            ->find()
            ->where([
                'Users.id' => $comment['user_id']
            ])
            ->first();
        //Check if this user hasn't already a notification. (Prevent for spam)
        $hasReplied = $this->Notifications
            ->find()
            ->where([
                'Notifications.foreign_key' => $event->data['comment_id'],
                'Notifications.type' => $event->data['type'],
                'Notifications.user_id' => $event->data['sender_id']
            ])
            ->first();
        if (!is_null($hasReplied)) {
            $hasReplied->data = serialize(['sender' => $sender, 'comment' => $comment]);
            $hasReplied->is_read = 0;
            $this->Notifications->save($hasReplied);
        } else {
            $data = [];
            $data['user_id'] = $event->data['sender_id'];
            $data['type'] = $event->data['type'];
            $data['data'] = serialize(['sender' => $sender, 'comment' => $comment]);
            $data['foreign_key'] = $comment['id'];
            $entity = $this->Notifications->newEntity($data);
            $this->Notifications->save($entity);
        }
        return true;

    }

     /**
     * A user has posted a comment to a perle.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return bool
     */
    protected function _perleSaid(Event $event)
    {

        if (!is_integer($event->data['perle_id'])) {
            return false;
        }
        $this->Perles = TableRegistry::get('Perles');
        $this->Users = TableRegistry::get('Users');
        $perle = $this->Perles
            ->find()
            ->where([
                'Perles.id' => $event->data['perle_id']
            ])
            ->select([
                'id', 'user_id'
            ])
            ->first();

        $sender = $this->Users
            ->find()
            ->where([
                'Users.id' => $event->data['sender_id']
            ])
            ->first();
        //Check if this user hasn't already a notification. (Prevent for spam)
        $hasReplied = $this->Notifications
            ->find()
            ->where([
                'Notifications.foreign_key' => $perle['id'],
                'Notifications.type' => $event->data['type'],
                'Notifications.user_id' => $sender['id']
            ])
            ->first();
        if (!is_null($hasReplied)) {
            $hasReplied->data = serialize(['sender' => $sender, 'perle' => $perle]);
            $hasReplied->is_read = 0;
            $this->Notifications->save($hasReplied);
        } else {
            $data = [];
            $data['user_id'] = $sender->id;
            $data['type'] = $event->data['type'];
            $data['data'] = serialize(['sender' => $sender, 'perle' => $perle]);
            $data['foreign_key'] = $perle['id'];
            $entity = $this->Notifications->newEntity($data);
            $this->Notifications->save($entity);
        }
        return true;

    }
    
    /**
     * A user has sign up on the website.
     *
     * @param \Cake\Event\Event $event The event that was fired.
     *
     * @return bool
     */
    protected function _bot(Event $event)
    {
        $this->Users = TableRegistry::get('Users');
        $user = $this->Users
            ->find()
            ->where(['id' => $event->data['user_id']])
            ->first();
        if (is_null($user)) {
            return false;
        }
        $data = [];
        $data['user_id'] = $user->id;
        $data['type'] = $event->data['type'];
        $data['data'] = serialize(['icon' => 'img/notifications/welcome.png']);
        $entity = $this->Notifications->newEntity($data);
        $this->Notifications->save($entity);
        return true;
    }
}