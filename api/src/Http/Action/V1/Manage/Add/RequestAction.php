<?php

namespace App\Http\Action\V1\Manage\Add;

use App\Http\EmptyResponse;
use App\Http\JsonResponse;
use App\Http\Validator\Validator;
use App\Manage\Command\AddSubscriber\Request\Command;
use App\Manage\Command\AddSubscriber\Request\Handler;
use DomainException;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use stdClass;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
        $command->phoneNumber = ($data['phoneNumber'] ?? '');
        $command->subscriberType = ($data['subscriberType'] ?? '');
        // Частное лицо
        /**
         * @psalm-var array $command->subData
         */
        if ($command->subscriberType == 'private') {
            $command->subData['firstname'] = ($data['firstname'] ?? '');
            $command->subData['surname'] = ($data['surname'] ?? '');
            $command->subData['patronymic'] = ($data['patronymic'] ?? '');
        }elseif ($command->subscriberType == 'private') {
            $command->subData['organizationName'] = ($data['organizationName'] ?? '');
            $command->subData['departmentName'] = ($data['departmentName'] ?? '');
            $command->subData['country'] = ($data['country'] ?? '');
            $command->subData['city'] = ($data['city'] ?? '');
            $command->subData['street'] = ($data['street'] ?? '');
            $command->subData['houseNumber'] = ($data['houseNumber'] ?? '');
            if (($data['floatNumber'])) {
                $command->subData['floatNumber'] = ($data['floatNumber'] ?? '');
            }
        }

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new EmptyResponse(201);
    }
}
