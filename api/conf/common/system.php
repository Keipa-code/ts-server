<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

return [
        'settings' => [
            'base_path' => '',
            'env' => getenv('APP_ENV') ?: 'prod',
            'route_cache' => __DIR__ . '/../../var/cache/routes',
            'displayErrorDetails' => (bool)getenv('APP_DEBUG'),
            'logErrors' => true,
            ],
        ];
