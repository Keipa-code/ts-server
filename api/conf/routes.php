<?php

declare(strict_types=1);

use App\Http\Action\V1\Manage;
use Slim\App;
use App\Http\Action\V1\PhoneList;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app): void {
    $app->get('/', 'App\Http\Action\V1\PhoneList\SearchByFIO\RequestAction:index')->setName('index');
    $app->get('/list', 'App\Http\Action\V1\PhoneList\SearchByFIO\RequestAction:handle')->setName('list');
    $app->post('/v1/search', PhoneList\SearchByNumber\RequestAction::class);
    $app->post('/v1/search/fio', PhoneList\SearchByFIO\RequestAction::class);
    $app->post('/v1/search/orgname', PhoneList\SearchByOrganizationName\RequestAction::class);
    $app->post('/v1/manage/add', Manage\Add\RequestAction::class);
    $app->post('/v1/manage/update', Manage\Update\RequestAction::class);
};
