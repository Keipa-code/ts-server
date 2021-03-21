<?php

declare(strict_types=1);

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return [
    LoggerInterface::class => function (ContainerInterface $container) {
        /**
         * @var string[] $loggerSettings
         */
        $loggerSettings = $container->get('logger');
        $logger = new Logger($loggerSettings['name']);
        $processor = new UidProcessor();
        $logger->pushProcessor($processor);
        $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
        $logger->pushHandler($handler);
        return $logger;
    },
    'logger' => [
        'name' => 'slim-app',
        'path' => getenv('docker') ? 'php://stdout' : __DIR__ . '/../../var/log/app.log',
        'level' => (getenv('APPLICATION_ENV') != 'production') ? Logger::DEBUG : Logger::INFO,
    ],
];
