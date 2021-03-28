<?php

namespace App\Http\Action\V1\Manage\Update;

use App\Http\EmptyResponse;
use App\Http\Validator\Validator;
use App\Manage\Command\UpdateSubscriber\Request\Command;
use App\Manage\Command\UpdateSubscriber\Request\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RequestAction implements RequestHandlerInterface
{
    private Handler $handler;

    private Validator $validator;

    public function __construct(Handler $handler, Validator $validator)
    {
        $this->handler = $handler;
        $this->validator = $validator;
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

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new EmptyResponse(201);
    }
}
