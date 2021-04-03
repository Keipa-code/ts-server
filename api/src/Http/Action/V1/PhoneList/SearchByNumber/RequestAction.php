<?php

namespace App\Http\Action\V1\PhoneList\SearchByNumber;

use App\Http\EmptyResponse;
use App\Http\JsonResponse;
use App\Http\Validator\Validator;
use App\PhoneList\Command\SearchByNumber\Request\Command;
use App\PhoneList\Command\SearchByNumber\Request\Handler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

class RequestAction  implements RequestHandlerInterface
{
    private Handler $handler;

    private Validator $validator;

    private LoggerInterface $logger;

    private Twig $view;

    public function __construct(Handler $handler, Validator $validator, ContainerInterface $container)
    {
        $this->handler = $handler;
        $this->validator = $validator;
        $this->logger = $container->get(LoggerInterface::class);
        $this->view = $container->get('view');
    }

    protected function render(Request $request, Response $response, string $template, array $params = []): Response
    {
        return $this->view->render($response, $template, $params);
    }

    public function handle(Request $request): Response
    {
        /**
         * @psalm-var string[] $data
         * @psalm-suppress MixedArrayAccess
         */
        $data = $request->getParsedBody();

        $command = new Command();
        $command->phonenumber = $data['phonenumber'];
        $this->validator->validate($command);

        $var = $this->handler->handle($command, $this->logger);
        return new JsonResponse($var);
    }
}
