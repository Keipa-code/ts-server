<?php

namespace App\Http\Action\V1\Manage\Add;

use App\Http\EmptyResponse;
use App\Http\JsonResponse;
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

class RequestAction implements RequestHandlerInterface
{
    private Handler $handler;

    private LoggerInterface $logger;

    public function __construct(Handler $handler, ContainerInterface $container)
    {
        $this->handler = $handler;
        $this->logger = $container->get(LoggerInterface::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /**
         * @psalm-var array{
         *     phoneNumber:string,
         *     subscriberType:string,
         *     private:string[],
         *     juridical:string[]
         * } $data
         * @psalm-suppress MixedArrayAccess
         */
        $data = json_decode((string) $request->getBody(), true);

        $command = new Command();
        $command->phoneNumber = trim($data['phoneNumber'] ?? '');
        $command->subscriberType = trim($data['subscriberType'] ?? '');
        // Частное лицо
        $command->subData['private']['firstname'] = trim($data['private']['firstname'] ?? '');
        $command->subData['private']['surname'] = trim($data['private']['surname'] ?? '');
        $command->subData['private']['patronymic'] = trim($data['private']['patronymic'] ?? '');
        // Юр лицо
        $command->subData['juridical']['organizationName'] = trim($data['organizationName'] ?? '');
        $command->subData['juridical']['departmentName'] = trim($data['departmentName'] ?? '');
        $command->subData['juridical']['country'] = trim($data['country'] ?? '');
        $command->subData['juridical']['city'] = trim($data['city'] ?? '');
        $command->subData['juridical']['street'] = trim($data['street'] ?? '');
        $command->subData['juridical']['houseNumber'] = trim($data['houseNumber'] ?? '');
        $command->subData['juridical']['floatNumber'] = trim($data['floatNumber'] ?? '');

        try {
            $this->handler->setLogger($this->logger);
            $this->handler->handle($command);

            return new EmptyResponse(201);
        } catch (DomainException $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], 409);
        }
    }
}
