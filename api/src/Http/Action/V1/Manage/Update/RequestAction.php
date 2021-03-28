<?php

namespace App\Http\Action\V1\Manage\Update;

use App\Http\EmptyResponse;
use App\Http\Validator\Validator;
use App\Manage\Command\UpdateSubscriber\Request\Command;
use App\Manage\Command\UpdateSubscriber\Request\Handler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class RequestAction implements RequestHandlerInterface
{
    private Handler $handler;

    private Validator $validator;

    private LoggerInterface $logger;

    public function __construct(Handler $handler, Validator $validator, ContainerInterface $container)
    {
        $this->handler = $handler;
        $this->validator = $validator;
        $this->logger = $container->get(LoggerInterface::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
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

        return new EmptyResponse(201);
    }
}
