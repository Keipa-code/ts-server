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
        $level = $loggerSettings['debug'] ? Logger::DEBUG : Logger::INFO;
        $logger = new Logger($loggerSettings['name']);

        if ($loggerSettings['stderr']) {
            $logger->pushHandler(new StreamHandler('php://stderr', $level));
        }

        if (!empty($loggerSettings['path'])) {
            $logger->pushHandler(new StreamHandler($loggerSettings['file'], $level));
        }

        $processor = new UidProcessor();
        $logger->pushProcessor($processor);

        return $logger;
    },
    'logger' => [
        'debug' => (bool)getenv('APP_DEBUG'),
        'stderr' => true,
        'name' => 'slim-app',
        'path' => __DIR__ . '/../../var/log/'. PHP_SAPI .'/app.log',
        'level' => (getenv('APPLICATION_ENV') != 'production') ? Logger::DEBUG : Logger::INFO,
    ],
];
