<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Flash\Messages;
use Slim\Routing\RouteContext;
use Symfony\Component\HttpFoundation\Session\Session;

final class UserAuthMiddleware implements MiddlewareInterface
{
    private ResponseFactoryInterface $responseFactory;
    private Session $session;

    public function __construct(
        ResponseFactoryInterface $responseFactory,
        Session $session
    ) {
        $this->responseFactory = $responseFactory;
        $this->session = $session;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        if ($this->session->get('user')) {
            // User is logged in
            return $handler->handle($request);
        }
        // User is not logged in. Redirect to login page.
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('login');

        return $this->responseFactory->createResponse()
            ->withStatus(302)
            ->withHeader('Location', $url);
    }
}
