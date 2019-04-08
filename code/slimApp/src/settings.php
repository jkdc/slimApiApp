<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'database' => [
            'host' => 'slim-dbserver',
            'port' => '9200',
            'scheme' => 'http',
        ],
        'tableSchemas' => [
            'recipe' => [
                'index' => 'test',
                'type'   => 'recipe'
            ]
        ]
    ],
];
