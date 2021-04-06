<?php

declare(strict_types=1);

use App\Http\Middleware\ClearEmptyInput;
use App\Http\Middleware\DomainExceptionHandler;
use App\Http\Middleware\SessionMiddleware;
use App\Http\Middleware\ValidationExceptionHandler;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\TwigMiddleware;

return function (App $app) {
    $app->add(SessionMiddleware::class);
    $app->add(TwigMiddleware::createFromContainer($app));
    $app->add(DomainExceptionHandler::class);
    $app->add(ValidationExceptionHandler::class);
    $app->add(ClearEmptyInput::class);
    $app->addBodyParsingMiddleware();
    $app->add(ErrorMiddleware::class);
};
