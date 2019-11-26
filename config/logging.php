<?php

return [
    'default' => env('LOG_CHANNEL', 'stack'),
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily'],
            'ignore_exceptions' => false,
        ],
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],
        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 14,
        ],
        'elasticsearch' => [
            'driver' => 'monolog',
            'handler' => Monolog\Handler\ElasticsearchHandler::class,
            'with' => [
                'client' => \Elasticsearch\ClientBuilder::create()
                        ->setHosts(explode(',', env('ELASTIC_HOST')))
                        ->build(),
                'options' => [
                    'index' => 'storage-log', // Elastic index name
                    'type' => '_doc', // Elastic document type
                    'ignore_error' => false, // Suppress Elasticsearch exceptions
                ],
            ],
            'formatter' => Monolog\Formatter\ElasticsearchFormatter::class,
            'formatter_with' => [
                'index' => 'storage-log',
                'type' => '_doc',
            ],
        ],
    ],
];
