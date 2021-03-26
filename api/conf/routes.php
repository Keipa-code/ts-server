<?php

declare(strict_types=1);

use App\Http\Action\HomeAction;
use App\Http\Action\V1\Manage\Add\RequestAction;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app): void {
    $app->get('/', HomeAction::class);

    $app->post('/v1/manage/add', RequestAction::class);

};
