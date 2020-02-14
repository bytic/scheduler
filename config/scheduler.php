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
            'apiKey' => env('HEALTHCHECKS_API', ''),
        ]
    ]
];
