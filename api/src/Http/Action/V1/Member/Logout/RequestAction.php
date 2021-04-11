<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Member\Logout;

use App\Auth\Command\SignIn\Command;
use App\Auth\Command\SignIn\Handler;
use App\Http\BaseAction;
use App\Http\Validator\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RequestAction
{
    /**
     * @var Session
     */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function __invoke(
        Request $request,
        Response $response
    ): Response {
        // Logout user
        $this->session->invalidate();

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('index');

        return $response->withStatus(302)->withHeader('Location', $url);
    }
}
