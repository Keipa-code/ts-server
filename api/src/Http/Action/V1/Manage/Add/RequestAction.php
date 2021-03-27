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
        /**
         * @psalm-var array{
         *     private:string[],
         *     juridical:string[]
         * } $command->subData
         */
        $command->subData['private']['firstname'] = trim($data['private']['firstname'] ?? '');
        $command->subData['private']['surname'] = trim($data['private']['surname'] ?? '');
        $command->subData['private']['patronymic'] = trim($data['private']['patronymic'] ?? '');
        // Юр лицо
        $command->subData['juridical']['organizationName'] = trim($data['juridical']['organizationName'] ?? '');
        $command->subData['juridical']['departmentName'] = trim($data['juridical']['departmentName'] ?? '');
        $command->subData['juridical']['country'] = trim($data['juridical']['country'] ?? '');
        $command->subData['juridical']['city'] = trim($data['juridical']['city'] ?? '');
        $command->subData['juridical']['street'] = trim($data['juridical']['street'] ?? '');
        $command->subData['juridical']['houseNumber'] = trim($data['juridical']['houseNumber'] ?? '');
        $command->subData['juridical']['floatNumber'] = trim($data['juridical']['floatNumber'] ?? '');

        try {
            $this->handler->handle($command);
            return new EmptyResponse(201);
        } catch (DomainException $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], 409);
        }
    }
}
