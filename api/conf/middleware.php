<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Views\TwigMiddleware;

return function (App $app, ContainerInterface $container) {
    $app->add(TwigMiddleware::createFromContainer($app));
    $settings = $container->get('settings');
    $app->addErrorMiddleware($settings['displayErrorDetails'], $settings['env'] !== 'test', $settings['logErrors']);
};
