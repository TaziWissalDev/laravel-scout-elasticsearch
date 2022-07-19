<?php

return [
    'host' => env('SCOUT_ELASTICSEARCH_HOST', '127.0.0.1'),
    'port' => env('SCOUT_ELASTICSEARCH_PORT', 9200),
    'scheme' => env('SCOUT_ELASTICSEARCH_SCHEME', null),
    'user' => env('SCOUT_ELASTICSEARCH_USER', null),
    'pass' => env('SCOUT_ELASTICSEARCH_PASSWORD', null),

    'aws_enable' => env('SCOUT_ELASTICSCOUT_AWS_ENABLED', false),
    'aws_region' => env('SCOUT_ELASTICSCOUT_AWS_REGION', 'us-east-1'),
    'aws_key' => env('AWS_ACCESS_KEY_ID', ''),
    'aws_secret' => env('AWS_SECRET_ACCESS_KEY', ''),
    'password' => env('ELASTICSEARCH_PASSWORD', null),
    'cloud_id' => env('ELASTICSEARCH_CLOUD_ID'),
    'api_key' => env('ELASTICSEARCH_API_KEY'),
    'indices' => [
        'mappings' => [
            'default' => [
                'properties' => [
                    'id' => [
                        'type' => 'keyword',
                    ],
                ],
            ],
        ],
        'settings' => [
            'default' => [
                'number_of_shards' => 1,
                'number_of_replicas' => 0,
            ],
        ],
    ],
];
