<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\TwigMiddleware;

return function (App $app) {
    $app->add(TwigMiddleware::createFromContainer($app));
    $app->add(ErrorMiddleware::class);
};
