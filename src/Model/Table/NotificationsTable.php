<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Routing\Router;
use Cake\Utility\Text;

class NotificationsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('notifications');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * Custom finder for map the ntofications.
     *
     * @param \Cake\ORM\Query $query The query finder.
     * @param array $options The options passed in the query builder.
     *
     * @return \Cake\ORM\Query
     */
    public function findMap(Query $query, array $options)
    {
        return $query
            ->formatResults(function ($notifications) use ($options) {
                return $notifications->map(function ($notification) use ($options) {
                    $notification->data = unserialize($notification->data);

                    switch ($notification->type) {
                        case 'bot':
                            $notification->text = __(
                                'Bienvenue sur Perle.',
                                \Cake\Core\Configure::read('Site.name')
                            );
                            $notification->link = Router::url(['controller' => 'pages', 'action' => 'home']);
                            $notification->icon = $notification->data['icon'];
                            // Mobile
                            $notification->mobile_text = __(
                                'Bienvenue sur Perle.',
                                \Cake\Core\Configure::read('Site.name')
                            );
                            $notification->mobile_image = $notification->data['icon'];
                            $notification->mobile_color_image = '#000';
                            $notification->mobile_url = '/perle/10';
                            break;

                            case 'perle.comment':
                            $full_name = $notification->data['sender']->first_name . ' ' . $notification->data['sender']->last_name;
                            $notification->text = '<strong>' . $full_name . '</strong> a commenté la perle que vous avez ajouté.';
                            $notification->mobile_text = $full_name . ' a commenté la perle que vous avez ajouté.';
                            $notification->mobile_image = $notification->data['sender']->avatar;
                            $notification->mobile_color_image = $notification->data['sender']->perle_color;
                            $notification->mobile_url = '/perle/10';
                            break;

                            case 'perle.said':
                            $full_name = $notification->data['sender']->first_name . ' ' . $notification->data['sender']->last_name;
                            $notification->mobile_text = $full_name . ' a indiquer que vous avez dit une perle...';
                            $notification->mobile_image = $notification->data['sender']->avatar;
                            $notification->mobile_color_image = $notification->data['sender']->perle_color;
                            $notification->mobile_url = '/perle/10';
                            break;

                    }

                    return $notification;
                });
            });
    }
}
