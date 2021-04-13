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
        $group->get('[/]', 'App\Http\Action\V1\Manage\GetPrivateList\RequestAction:handle')->setName('manage');
        $group->get('/private', 'App\Http\Action\V1\Manage\GetPrivateList\RequestAction:handle')->setName('private');
        $group->get('/juridical', 'App\Http\Action\V1\Manage\GetJuridicalList\RequestAction:handle')->setName('juridical');
        $group->get('/logout', 'App\Http\Action\V1\Member\Logout\RequestAction')->setName('logout');
        $group->post('/add', 'App\Http\Action\V1\Manage\Add\RequestAction:handle')->setName('add');
        $group->get('/add/private', 'App\Http\Action\V1\Manage\AddPrivate\RequestAction:handle')->setName('addPrivate');
        $group->get('/add/juridical', 'App\Http\Action\V1\Manage\AddJuridical\RequestAction:handle')->setName('addJuridical');
        $group->get('/edit/private/[{uuid}]', 'App\Http\Action\V1\Manage\EditPrivate\RequestAction:handle')->setName('editPrivate');
        $group->get('/edit/juridical/[{uuid}]', 'App\Http\Action\V1\Manage\EditJuridical\RequestAction:handle')->setName('editJuridical');
        $group->post('/update', 'App\Http\Action\V1\Manage\Update\RequestAction:handle')->setName('update');
        $group->get('/remove/[{uuid}]', 'App\Http\Action\V1\Manage\Remove\RequestAction:handle')->setName('remove');
    })->add(UserAuthMiddleware::class);
};
