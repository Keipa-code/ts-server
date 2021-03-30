<?php

declare(strict_types=1);

use App\Http\Action\HomeAction;
use App\Http\Action\V1\Manage;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app): void {
    $app->get('/', 'App\Http\Action\HomeAction:handle');

    $app->post('/v1/manage/add', Manage\Add\RequestAction::class);
    $app->post('/v1/manage/update', Manage\Update\RequestAction::class);
};
