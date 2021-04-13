<?php

namespace App\Http\Action\V1\Manage\Update;

use App\Http\BaseAction;
use App\Http\EmptyResponse;
use App\Http\Validator\Validator;
use App\Manage\Command\UpdateSubscriber\Request\Command;
use App\Manage\Command\UpdateSubscriber\Request\Handler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Slim\Flash\Messages;
use Slim\Routing\RouteContext;

class RequestAction extends BaseAction
{
    private Handler $handler;
    private Validator $validator;
    private Messages $flash;

    public function __construct(
        Handler $handler,
        Validator $validator,
        ContainerInterface $container
    ) {
        parent::__construct($container);
        $this->handler = $handler;
        $this->validator = $validator;
        $this->flash = $container->get(Messages::class);
    }

    public function handle(Request $request, Response $response, array $args = []): Response
    {
        /**
         * @psalm-var string[] $data
         * @psalm-suppress MixedArrayAccess
         */
        $data = $request->getParsedBody();

        $command = new Command();
        $command->writeData($data);
        //$this->logger->warning('yatuta');
        $this->validator->validate($command);

        $this->handler->handle($command, $this->logger);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('manage').'/edit/'.$command->subscriberType.$command->id;
        $this->flash->addMessage('success', 'Абонент обновлён');
        return $response
            ->withStatus(302)
            ->withHeader('Location', $url);
    }
}
