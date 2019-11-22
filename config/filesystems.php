<?php

return [
    'default' => env('FILESYSTEM_DRIVER', 's3'),
    'cloud' => env('FILESYSTEM_CLOUD', 's3'),
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => app()->basePath('public/storage'),
            'url' => '/upload',
            'visibility' => 'public',
        ],
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
            'region' => env('AWS_REGION'),
            'endpoint' => env('AWS_URL'),
            'bucket' => env('AWS_BUCKET'),
            'use_path_style_endpoint' => true
        ],
    ],
];
