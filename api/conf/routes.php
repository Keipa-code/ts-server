<?php

declare(strict_types=1);

use App\Http\Action\HomeAction;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app): void {
    $app->get('/', HomeAction::class);

    $app->group('/v1', function (RouteCollectorProxy $group): void {
        $group->group('/manage', function (RouteCollectorProxy $group): void {
            $group->post('/add', \App\Http\Action\V1\Manage\Add\RequestAction::class);
        });
    });
};
