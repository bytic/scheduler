<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Scheduler Name
    |--------------------------------------------------------------------------
    |
    */
    'name' => env('APP_SITE', 'Application'),

    'pingers' => [
        'healthchecks' => [
            'endpoint' => env('HEALTHCHECKS_ENDPOINT', null),
            'apiKey' => env('HEALTHCHECKS_API', ''),
        ]
    ]
];
