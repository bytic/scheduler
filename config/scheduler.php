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

    /*
    |--------------------------------------------------------------------------
    | Default Driver
    |--------------------------------------------------------------------------
    |
    | The default driver used when publishing events.
    | Supported: "crontab", "database", "internal"
    |
    */
    'driver' => env('SCHEDULER_DRIVER', 'crontab'),

    /*
    |--------------------------------------------------------------------------
    | Database Driver Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the DatabaseDriver used to store and run scheduled tasks.
    | The 'table' option specifies the database table name.
    |
    */
    'database' => [
        'table'      => env('SCHEDULER_DB_TABLE', 'scheduled_tasks'),
        'connection' => env('SCHEDULER_DB_CONNECTION', null),
    ],

    'pingers' => [
        'healthchecks' => [
            'endpoint' => env('HEALTHCHECKS_ENDPOINT', null),
            'apiKey' => env('HEALTHCHECKS_API', ''),
        ]
    ]
];
