<?php

declare(strict_types=1);

use App\Http\Middleware\UserAuthMiddleware;
use Slim\App;
use App\Http\Action\V1;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app): void {
    $app->get('/', 'App\Http\Action\V1\PhoneList\SearchByFIO\RequestAction:index')->setName('index');
    $app->get('/list', 'App\Http\Action\V1\PhoneList\SearchByFIO\RequestAction:handle')->setName('list');
    $app->post('/v1/search', V1\PhoneList\SearchByNumber\RequestAction::class);
    $app->post('/v1/search/fio', V1\PhoneList\SearchByFIO\RequestAction::class);
    $app->post('/v1/search/orgname', V1\PhoneList\SearchByOrganizationName\RequestAction::class);
    $app->map(['GET', 'POST'], '/v1/login', 'App\Http\Action\V1\Member\Login\RequestAction:handle')->setName('login');
    $app->get('/v1/logout', V1\Member\Logout\RequestAction::class);

    $app->group('/v1/manage', function (RouteCollectorProxy $group) {
        $group->get('[/]', 'App\Http\Action\V1\Manage\SubList\RequestAction:handle')->setName('manage');
        $group->post('/add', V1\Manage\Add\RequestAction::class);
        $group->post('/update', V1\Manage\Update\RequestAction::class);
        $group->post('/remove', V1\Manage\Update\RequestAction::class);
    })->add(UserAuthMiddleware::class);
};
