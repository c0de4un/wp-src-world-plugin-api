<?php

return [
    'api'     => [
        'srcw/v1'         => [
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
