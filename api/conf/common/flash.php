<?php

declare(strict_types=1);

use Neoflow\FlashMessages\Flash;
use Neoflow\FlashMessages\FlashInterface;
use Neoflow\FlashMessages\Middleware\FlashMiddleware;
use Psr\Container\ContainerInterface;
use Slim\Flash\Messages;

return [
    Messages::class => function () {
        $storage = [];
        return new Messages($storage);
    },
    FlashInterface::class => function () {
        $key = '_flashMessages'; // Key as identifier of the messages in the storage
        return new Flash($key);
    },
    FlashMiddleware::class => function (ContainerInterface $container) {
        $flash = $container->get(FlashInterface::class);
        return new FlashMiddleware($flash);
    },
];
