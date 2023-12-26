<?php

return [
    'ttl' => [
        'access' => env('ACCESS_TOKEN_TTL', 20),
        'refresh' => env('REFRESH_TOKEN_TTL', 60),
    ]
];