<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Middleware\ErrorMiddleware;

return [
    ErrorMiddleware::class => static function (ContainerInterface $container): ErrorMiddleware{
        $callableResolver = $container->get(CallableResolverInterface::class);

        $responseFactory = $container->get(ResponseFactoryInterface::class);

        $settings = $container->get('settings')['errors'];

        return new ErrorMiddleware(
            $callableResolver,
            $responseFactory,
            $settings['displayErrorDetails'],
            true,
            true
        );
    },


    'settings' => [
        'errors' => [
            'displayErrorDetails' => (bool)getenv('APP_DEBUG')
        ]
    ]
];