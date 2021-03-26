<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\TwigMiddleware;

return function (App $app, ContainerInterface $container) {
    $app->add(TwigMiddleware::createFromContainer($app));
    /**
     * @psalm-suppress MixedArrayAccess
     * @psalm-var array{
     *     displayErrorDetails:bool,
     *     logErrors:string
     * }
     */
    $settings = $container->get('settings')['errors'];
    $app->addErrorMiddleware($settings['displayErrorDetails'], $settings['logErrors'] !== 'test', true);
};
