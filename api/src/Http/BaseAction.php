<?php

declare(strict_types=1);

namespace App\Http;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Flash\Messages;
use Slim\Views\Twig;

class BaseAction
{
    protected Twig $view;
    protected LoggerInterface $logger;

    public function __construct(ContainerInterface $container)
    {
        $this->view = $container->get('view');
        $this->logger = $container->get(LoggerInterface::class);
    }

    protected function render(Request $request, Response $response, string $template, array $params = []): Response
    {
        $params['uinfo'] = $request->getAttribute('uinfo');

        return $this->view->render($response, $template, $params);
    }
}
