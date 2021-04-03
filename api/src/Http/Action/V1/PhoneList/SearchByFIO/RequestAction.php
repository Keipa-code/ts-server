<?php

namespace App\Http\Action\V1\PhoneList\SearchByFIO;

use App\Http\BaseAction;
use App\Http\EmptyResponse;
use App\Http\JsonResponse;
use App\Http\Validator\Validator;
use App\Manage\Command\Entity\Subscriber\PrivateSubscriber;
use App\PhoneList\Command\SearchByFIO\Request\Command;
use App\PhoneList\Command\SearchByFIO\Request\Handler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

class RequestAction extends BaseAction
{
    private Handler $handler;
    private Validator $validator;

    public function __construct(Handler $handler, Validator $validator, ContainerInterface $container)
    {
        parent::__construct($container);
        $this->handler = $handler;
        $this->validator = $validator;
    }

    public function index(Request $request, Response $response, array $args = []): Response
    {
        $this->logger->info("Home page action dispatched");

        return $this->render($request, $response, 'index.twig');
    }

    public function handle(Request $request, Response $response, array $args = []): Response
    {
        /**
         * @psalm-var string[] $data
         * @psalm-suppress MixedArrayAccess
         */
        $data = $request->getQueryParams();
        //$data = $args;
        $command = new Command();
        $this->logger->warning(json_encode($data));
        $command->fio = mb_strtolower($data['fio']);

        $this->validator->validate($command);
        $list = $this->handler->handle($command, $this->logger);

        //$this->logger->warning($numbers['0']->getPhonenumbers()['0']->getFormattedNumber());
        return $this->render($request, $response, 'list.twig', ['list' => $list, 'fio' => $data['fio']]);
    }
}
