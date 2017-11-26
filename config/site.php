<?php
return [
    'Author' => [
        'full_name' => 'Brian Millit',
        'pseudo' => 'Xeta',
        'twitter' => 'https://twitter.com/FMT_ZoRo',
        'facebook' => 'https://facebook.com/Emeric.ZoRRo',
        'email' => 'zoro.fmt@gmail.com',
        'address' => 'Chalon sur Saône, 71100 France'
    ],
    'Site' => [
        'name' => 'Xeta',
        'description' => 'You will find content related to web development like tutorials, my personal tests on new technologies etc',
        'github_url' => 'https://github.com/Xety/Xeta',
        'analytics_tracker_code' => 'UA-40328289-2',
        'full_url' => 'https://xeta.io'
    ],
    'Home' => [
        'articles' => 8,
        'comments' => 8
    ],
    'Blog' => [
        'article_per_page' => 10,
        'comment_per_page' => 10
    ],
    'User' => [
        'Profile' => [
            'max_blog_articles' => 5,
            'max_blog_comments' => 5,
            'max_forum_threads' => 5,
            'max_forum_posts' => 5
        ],
        'ResetPassword' => [
            'expire_code' => 10 //In minutes.
        ],
        'user_per_page' => 15,
        'transaction_per_page' => 15,
        'max_notifications' => 5,
        'notifications_per_page' => 15
    ],
    'Group' => [
        'user_per_page' => 15
    ]
];