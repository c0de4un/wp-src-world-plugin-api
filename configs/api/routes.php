<?php

return [
    'api'     => [
        'srcw/v1'         => [
            'graphql'   => [
                'methods'        => 'GET',
                'function'       => 'index',
                'controller'     => 'includes/controllers/class-srcw-graphql-controller.php',
                'class'          => 'SRCWGraphQLController',                
            ],

            'auth'      => [
                'methods'        => 'POST',
                'controller'     => 'includes/controllers/class-srcw-auth-controller.php',
                'class'          => 'SRCWAuthController',
            ],
            'logout'    => [
                'methods'        => 'POST',
                'controller'     => 'includes/controllers/class-srcw-auth-controller.php',
                'class'          => 'SRCWAuthController',
            ],
        ],
    ],
];
