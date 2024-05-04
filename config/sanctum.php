<?php

use Laravel\Sanctum\Sanctum;

return [
    'stateful' => explode(',', env(
        'SANCTUM_STATEFUL_DOMAINS', 'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000'
    )),

    'expiration' => null,

    'middleware' => [
        'verify_csrf_token' => true,
    ],
];
