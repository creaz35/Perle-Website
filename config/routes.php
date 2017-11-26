<?php
use Cake\Core\Plugin;
use Cake\Routing\Router;
Router::extensions(['json', 'xml']);
Router::defaultRouteClass('InflectedRoute');

Router::prefix('api', function ($routes) {
    $routes->extensions(['json', 'xml']);
    $routes->resources('Cocktails');
    $routes->resources('Users');

    Router::connect('/api/users/register', ['controller' => 'Users', 'action' => 'add', 'prefix' => 'api']);

    $routes->fallbacks('InflectedRoute');
});

//Public routes.
Router::scope('/', function ($routes) {
    
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'home']);
    $routes->connect('/sendEmail', ['controller' => 'Pages', 'action' => 'sendEmail']);

    $routes->connect('/legals', ['controller' => 'Pages', 'action' => 'legals']);
    $routes->connect('/cgu', ['controller' => 'Pages', 'action' => 'cgu']);

    $routes->connect(
        '/users/resetPassword/:code.:id',
        [
            'controller' => 'users',
            'action' => 'resetPassword'
        ],
        [
            '_name' => 'users-resetpassword',
            'pass' => [
                'id',
                'code'
            ],
            'id' => '[0-9]+'
        ]
    );
    
    $routes->fallbacks();
});
//Admin routes.
Router::prefix('admin', function ($routes) {
    $routes->connect(
        '/',
        [
            'controller' => 'admin',
            'action' => 'index'
        ]
    );
    $routes->connect(
        '/getChart',
        [
            'controller' => 'admin',
            'action' => 'getChart'
        ]
    );
    $routes->fallbacks();
});
/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
    Plugin::routes();