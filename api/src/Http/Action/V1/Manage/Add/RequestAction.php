<?php


namespace App\Http\Action\V1\Manage\Add;


use App\Http\JsonResponse;
use App\Manage\Command\AddSubscriber\Request\Command;
use App\Manage\Command\AddSubscriber\Request\Handler;
use DomainException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RequestAction implements RequestHandlerInterface
{
    private Handler $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = json_decode((string) $request->getBody(), true);

        $command = new Command();
        $command->phoneNumber = trim($data['phoneNumber'] ?? '');
        $command->subscriberType = trim($data['subscriberType'] ?? '');
        // Частное лицо
        $command->subData['private']['firstname'] = trim($data['firstname'] ?? '');
        $command->subData['private']['surname'] = trim($data['surname'] ?? '');
        $command->subData['private']['patronymic'] = trim($data['patronymic'] ?? '');
        // Юр лицо
        $command->subData['juridical']['organizationName'] = trim($data['organizationName'] ?? '');
        $command->subData['juridical']['departmentName'] = trim($data['departmentName'] ?? '');
        $command->subData['juridical']['country'] = trim($data['country'] ?? '');
        $command->subData['juridical']['city'] = trim($data['city'] ?? '');
        $command->subData['juridical']['street'] = trim($data['street'] ?? '');
        $command->subData['juridical']['houseNumber'] = trim($data['houseNumber'] ?? '');
        $command->subData['juridical']['floatNumber'] = trim($data['floatNumber'] ?? '');

        try {
            $this->handler->handle($command);
            return new JsonResponse(new \stdClass(), 201);
        }catch (DomainException $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], 409);
        }

    }
}