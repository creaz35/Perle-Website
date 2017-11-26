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
use App\Event\Notifications;
use Cake\I18n\Time;
use Cake\Network\Email\Email;
use Cake\View\Helper\PaginatorHelper;
use Intervention\Image\ImageManager;
use Cake\Log\Log;


class PerlesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['index', 'add', 'getItem', 'dislike', 'undislike', 'like', 'unlike']);

    }

    public function index() {

        $user = $this->Auth->identify();
        $json = array();
        if (!$user) {
            throw new UnauthorizedException('Invalid email or password');
        }

        if ($this->request->data['userId'])
            $userId = $this->request->data['userId'];
        else
            $userId = $user['userId'];

        if ($this->request->data['type']) 
            $type = $this->request->data['type'];
        else
            $type = '';

        switch($type) {
        case "perle":
            $this->paginate = [
                'conditions' => [
                    'Perles.user_id' => $userId
                ],
                'order' => [
                    'Perles.created' => 'DESC'
                ],
                'maxLimit' => 5,
                'page'     => $this->request->data['page']
            ];
            break;
        case "full_squizz":
            $this->paginate = [
                'conditions' => [
                    'Perles.type' => $type
                ],
                'order' => [
                    'Perles.created' => 'DESC'
                ],
                'maxLimit' => 5,
                'page'     => $this->request->data['page']
            ];
            break;
        default:
            $this->paginate = [
                'order' => [
                    'Perles.created' => 'DESC'
                ],
                'maxLimit' => 5,
                'page'     => $this->request->data['page']
            ];
        }

        $perles = $this->Perles
            ->find('all')
            ->contain([
                'Users',
                'PerleTaggedFriends.Users'
            ]);

        $perles = $this->paginate($perles);

        foreach ($perles->toArray() as $key => $v) {
            $perles->toArray()[$key]['liked'] = $v->liked;
            $perles->toArray()[$key]['disliked'] = $v->disliked;
        }

        $json['perles'] = $perles;
        $json['pagination'] = $this->request->params['paging'];
        $json['page'] = $this->request->data['page'];

        // Set the view vars that have to be serialized.
        $this->set('json', $json);
        // Specify which view vars JsonView should serialize.
        $this->set('_serialize', ['json']);

    }

    public function getItem() {

        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Invalid email or password');
        }

        // Perle
        $perle = $this->Perles
            ->find()
            ->contain([
                'Users',
                'PerleComments.Users'
            ])
            ->where([
                'Perles.id' => $this->request->data['perleId']
            ])
            ->first();

        // Set the view vars that have to be serialized.
        $this->set('perle', $perle);
        // Specify which view vars JsonView should serialize.
        $this->set('_serialize', ['perle']);

    }

    public function add()
    {

        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Invalid email or password');
        }

        // Save the data to the server 
        $perlesTable = TableRegistry::get('perles');
        $this->loadModel('Perles');
        $this->loadModel('Users');
        $this->loadModel('PerleTaggedFriends');
        $perle = $perlesTable->newEntity($this->request->data['perle']);
        $perle->user_id = $user['id'];
        $perle->said_by_user_name = $this->request->data['perle']['said_by']['text'];
        $perle->said_by_user_id = $this->request->data['perle']['said_by']['user_id'];

        //Log::write('error', $this->request->data['perle']['base_img']);
        //$this->log($this->data, 'error');

        // Save image
        if ((isset($this->request->data['perle']['base_img'])) && $this->request->data['perle']['base_img'] != '') { 
            $manager = new ImageManager();
            $base_64 = $this->request->data['perle']['base_img'];
            $pos  = strpos($base_64, ';');
            $type = explode(':', substr($base_64, 0, $pos))[1];
            $img = str_replace('data:'. $type . ';base64,', '', $base_64);
            $img = str_replace(' ', '+', $img);
            $base_64 = base64_decode($img);
            $directory = 'img/perles_post/' . rand(1,9999) . 'test.jpg';
            $path = $_SERVER['DOCUMENT_ROOT'] . 'webroot/' . $directory;
            $perle->perle_img = $directory;
        } else {
           $perle->perle_img = '';
        }

        if ($perlesTable->save($perle)) {

            if ($perle->perle_img != '') { 
                // Save Image
                $image = $manager->make($base_64);
                $image->save($path);
            }

            $item = $this->Perles
            ->find()
            ->contain([
                'Users',
                'PerleTaggedFriends.Users'
            ])
            ->where([
                'Perles.id' => $perle['id']
            ])
            ->first();

            $item['liked'] = 0;
            $item['disliked'] = 0;

            $this->set([
                'success' => true,
                'data' => [
                    'perle' => $item
                ],
                '_serialize' => ['success', 'data']
            ]);
        } else {
            $this->set([
                'success' => false,
                '_serialize' => ['success']
            ]);
        }

    }

    public function addComment()
    {

        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Invalid email or password');
        }

        $this->loadModel('PerleComments');

        // Save the data to the server 
        $perleCommentTable = TableRegistry::get('perle_comments');
        $comment = $perleCommentTable->newEntity($this->request->data());
        $comment->user_id = $user['id'];

        if ($perleCommentTable->save($comment)) {

            $comment = $this->PerleComments
            ->find()
            ->contain([
                'Users'
            ])
            ->where([
                'PerleComments.id' => $comment->id
            ])
            ->first();

            $this->set([
                'success' => true,
                'data' => [
                    'comment' => $comment
                ],
                '_serialize' => ['success', 'data']
            ]);
        } else {
            $this->set([
                'success' => false,
                '_serialize' => ['success']
            ]);
        }
    }

    /**
     * Like a perle.
     *
     * @param int $articleId Id of the perle to like.
     *
     * @throws \Cake\Network\Exception\NotFoundException When it's not an AJAX request.
     *
     * @return void
     */
    public function like()
    {
        
        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Invalid email or password');
        }
        //Check if the user hasn't already liked this article.
        $this->loadModel('PerlesLikes');
        $checkLike = $this->PerlesLikes
            ->find()
            ->where([
                'PerlesLikes.user_id' => $user['id'],
                'PerlesLikes.perle_id' => $this->request->data['perle_id']
            ])
            ->first();
        $json = [];
        if ($user['id'] == 1) {
           $this->set([
                'success' => false,
                'data' => [
                    'message' => 'you already like this perle!'
                ],
                '_serialize' => ['success', 'data']
            ]);
        }
        //Check if the article exist.
        $this->loadModel('Perles');
        $checkPerle = $this->Perles
            ->find()
            ->where([
                'Perles.id' => $this->request->data['perle_id']
            ])
            ->first();
        if (is_null($checkPerle)) {
             $this->set([
                'success' => false,
                'data' => [
                    'message' => 'this perle not exist!'
                ],
                '_serialize' => ['success', 'data']
            ]);
        }
        //Prepare data to be saved.
        $data = [];
        $data['PerlesLikes']['user_id'] = $user['id'];
        $data['PerlesLikes']['perle_id'] = $this->request->data['perle_id'];
        $like = $this->PerlesLikes->newEntity($data);
        if ($this->PerlesLikes->save($like)) {
            $this->set([
                'success' => true,
                'data' => [
                    'message' => 'this perle is liked!'
                ],
                '_serialize' => ['success', 'data']
            ]);
        } else {
           $this->set([
                'success' => false,
                'data' => [
                    'message' => 'unknown error!'
                ],
                '_serialize' => ['success', 'data']
            ]);
        }
    }

    public function unlike() {

        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Invalid email or password');
        }
        //Check if the user like this article.
        $this->loadModel('PerlesLikes');
        $like = $this->PerlesLikes
            ->find()
            ->contain([
                'Perles'
            ])
            ->where([
                'PerlesLikes.user_id' => $user['id'],
                'PerlesLikes.perle_id' => $this->request->data['perle_id']
            ])
            ->first();
        $json = [];
        if (is_null($like)) {
             $this->set([
                'success' => false,
                'data' => [
                    'message' => 'you dont like this pearl!'
                ],
                '_serialize' => ['success', 'data']
            ]);
        }
        if ($this->PerlesLikes->delete($like)) {
            $this->set([
                'success' => true,
                'data' => [
                    'message' => 'perle deleted!'
                ],
                '_serialize' => ['success', 'data']
            ]);
        } else {
            $this->set([
                'success' => false,
                'data' => [
                    'message' => 'unknown error!'
                ],
                '_serialize' => ['success', 'data']
            ]);
        }
    }

    public function dislike()
    {
        
        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Invalid email or password');
        }
        //Check if the user hasn't already liked this article.
        $this->loadModel('PerlesDisLikes');
        $checkdisLike = $this->PerlesDisLikes
            ->find()
            ->where([
                'PerlesDisLikes.user_id' => $user['id'],
                'PerlesDisLikes.perle_id' => $this->request->data['perle_id']
            ])
            ->first();
        if (!is_null($checkdisLike)) {
           $this->set([
                'success' => false,
                'data' => [
                    'message' => 'you already dislike this perle!'
                ],
                '_serialize' => ['success', 'data']
            ]);
        }
        //Check if the article exist.
        $this->loadModel('Perles');
        $checkPerle = $this->Perles
            ->find()
            ->where([
                'Perles.id' => $this->request->data['perle_id']
            ])
            ->first();
        if (is_null($checkPerle)) {
             $this->set([
                'success' => false,
                'data' => [
                    'message' => 'this perle not exist!'
                ],
                '_serialize' => ['success', 'data']
            ]);
        }
        //Prepare data to be saved.
        $data = [];
        $data['PerlesDisLikes']['user_id'] = $user['id'];
        $data['PerlesDisLikes']['perle_id'] = $this->request->data['perle_id'];
        $dislike = $this->PerlesDisLikes->newEntity($data);
        if ($this->PerlesDisLikes->save($dislike)) {
            $this->set([
                'success' => true,
                'data' => [
                    'message' => 'this perle is disliked!',
                    'user_id' => $user['id'],
                    'perle_id' => $this->request->data['perle_id']
                ],
                '_serialize' => ['success', 'data']
            ]);
        } else {
           $this->set([
                'success' => false,
                'data' => [
                    'message' => 'unknown error!'
                ],
                '_serialize' => ['success', 'data']
            ]);
        }
    }

    public function undislike() {

        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Invalid email or password');
        }
        //Check if the user dislike this article.
        $this->loadModel('PerlesDisLikes');
        $dislike = $this->PerlesDisLikes
            ->find()
            ->contain([
                'Perles'
            ])
            ->where([
                'PerlesDisLikes.user_id' => $user['id'],
                'PerlesDisLikes.perle_id' => $this->request->data['perle_id']
            ])
            ->first();
        $json = [];
        if (is_null($dislike)) {
             $this->set([
                'success' => false,
                'data' => [
                    'message' => 'you like this pearl!'
                ],
                '_serialize' => ['success', 'data']
            ]);
        }
        if ($this->PerlesDisLikes->delete($dislike)) {
            $this->set([
                'success' => true,
                'data' => [
                    'message' => 'perle deleted!'
                ],
                '_serialize' => ['success', 'data']
            ]);
        } else {
            $this->set([
                'success' => false,
                'data' => [
                    'message' => 'unknown error!'
                ],
                '_serialize' => ['success', 'data']
            ]);
        }
    }
}