<?php
use Cake\Core\Configure;

return [
    'HybridAuth' => [
        'providers' => [
            'Google' => [
                'enabled' => true,
                'keys' => [
                    'id' => '<google-client-id>',
                    'secret' => '<secret-key>'
                ]
            ],
            'Facebook' => [
                'enabled' => true,
                'keys' => [
                    'id' => '1833214560231634',
                    'secret' => '6de8d9c586a17118208db69fd384352f'
                ],
                'scope' => 'email'
            ],
            'Twitter' => [
                'enabled' => true,
                'keys' => [
                    'key' => '<twitter-key>',
                    'secret' => '<twitter-secret>'
                ],
                'includeEmail' => true // Only if your app is whitelisted by Twitter Support
            ]
        ],
        'debug_mode' => Configure::read('debug'),
        'debug_file' => LOGS . 'hybridauth.log',
    ]
];