<?php return [
    'default' => env('QUEUE_CONNECTION', 'database'), // Default driver
    'connections' => [
        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
        ],
    ],
    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database'),
//        'database' => 'database',
        'table' => 'failed_jobs',
    ],
];
