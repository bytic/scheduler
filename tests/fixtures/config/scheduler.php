<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Scheduler Name
    |--------------------------------------------------------------------------
    |
    */
    'name' => env('APP_SITE', 'Application'),
    'php_bin' => env('SCHEDULER_PHP_BIN', null),

    'pingers' => [
        'healthchecks' => [
            'endpoint' => env('HEALTHCHECKS_ENDPOINT', null),
            'apiKey' => env('HEALTHCHECKS_API', ''),
        ]
    ]
];
