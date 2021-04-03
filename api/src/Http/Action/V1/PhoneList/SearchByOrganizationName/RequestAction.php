<?php

namespace App\Http\Action\V1\PhoneList\SearchByOrganizationName;

use App\Http\JsonResponse;
use App\Http\Validator\Validator;
use App\PhoneList\Command\SearchByOrganizationName\Request\Command;
use App\PhoneList\Command\SearchByOrganizationName\Request\Handler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

class RequestAction implements RequestHandlerInterface
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
        $command->organizationName = mb_strtolower($data['organizationName']);
        $this->validator->validate($command);
        $subsList = $this->handler->handle($command, $this->logger);

        //$this->logger->warning($numbers['0']->getPhonenumbers()['0']->getFormattedNumber());
        return new JsonResponse($subsList);
    }
}
