<?php

namespace App\Http\Action\V1\Manage\Add;

use App\Http\BaseAction;
use App\Http\Validator\Validator;
use App\Manage\Command\AddSubscriber\Request\Command;
use App\Manage\Command\AddSubscriber\Request\Handler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

class RequestAction extends BaseAction
{
    private Validator $validator;
    private Handler $handler;

    public function __construct(
        Handler $handler,
        Validator $validator,
        ContainerInterface $container
    ) {
        parent::__construct($container);
        $this->validator = $validator;
        $this->handler = $handler;
    }

    public function handle(Request $request, Response $response): Response
    {
        /**
         * @psalm-var string[] $data
         * @psalm-suppress MixedArrayAccess
         */
        $data = $request->getParsedBody();

        $command = new Command();
        $command->phoneNumber = ($data['phonenumber'] ?? '');
        $command->subscriberType = ($data['type'] ?? '');
        // Частное лицо
        /**
         * @psalm-var array $command->subData
         */
        if ($command->subscriberType == 'private') {
            $command->subData['firstname'] = ($data['firstname'] ?? '');
            $command->subData['surname'] = ($data['surname'] ?? '');
            $command->subData['patronymic'] = ($data['patronymic'] ?? '');
        } elseif ($command->subscriberType == 'juridical') {
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

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('manage');
        return $response
            ->withStatus(302)
            ->withHeader('Location', $url);
    }
}
