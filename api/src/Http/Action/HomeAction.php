<?php

declare(strict_types=1);

namespace App\Http\Action;


use App\Http\JsonResponse;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;
use stdClass;

class HomeAction
{

    private Twig $view;

    public function __construct(ContainerInterface $container)
    {
        $this->view = $container->get('view');

    }

    protected function render(Request $request, Response $response, string $template, array $params = []): Response
    {
        return $this->view->render($response, $template, $params);
    }

    public function handle(Request $request, Response $response, array $args = []): Response
    {

        return $this->render($request, $response, 'index.twig');//new JsonResponse(new stdClass());
    }
}
