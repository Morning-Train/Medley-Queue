<?php return [
    'default' => env('QUEUE_CONNECTION', 'database'), // Default driver
    'connections' => [
        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
        ],
    ],
];
