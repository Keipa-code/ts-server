<?php

declare(strict_types=1);

use Monolog\Handler\NullHandler;
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

        $example_timezone = "Asia/Oral";



        //hack to force timezone to get set in logger the way we want it
        $original_timezone = date_default_timezone_get();
        date_default_timezone_set($example_timezone);
        $logger->pushHandler(new NullHandler());
        $logger->debug("");
        date_default_timezone_set($original_timezone);
        $logger->popHandler();

        //now we can add all our normal handlers
        $file_handler = new StreamHandler(fopen("somepath","w+"));
        $logger->pushHandler($file_handler);

        if ($loggerSettings['stderr']) {
            $logger->pushHandler(new StreamHandler('php://stderr', $level));
        }

        if (!empty($loggerSettings['file'])) {
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
        'file' => __DIR__ . '/../../var/log/' . PHP_SAPI . '/app.log',
        'level' => (getenv('APPLICATION_ENV') != 'production') ? Logger::DEBUG : Logger::INFO,
    ],
];
