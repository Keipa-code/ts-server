<?php

declare(strict_types=1);


use App\Http\Middleware\SessionMiddleware;
use Psr\Container\ContainerInterface;
use Slim\Flash\Messages;

return [
    'session' => function(){
    return new SessionMiddleware;
    },
    'flash' => function (ContainerInterface $container) {
        $session = $container->get('session');
        return new Messages($session);
    }
];