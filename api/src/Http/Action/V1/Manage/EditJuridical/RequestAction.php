<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Manage\EditJuridical;

use App\Http\BaseAction;
use App\Http\Service\Link;
use App\Http\Service\PageCounter;
use App\Http\Validator\Validator;
use App\Manage\Command\GetById\Command;
use App\Manage\Command\GetById\Handler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RequestAction extends BaseAction
{
    private Validator $validator;
    private Handler $handler;
    private PageCounter $counter;

    public function __construct(
        Handler $handler,
        Validator $validator,
        ContainerInterface $container,
        PageCounter $counter
    ) {
        parent::__construct($container);
        $this->validator = $validator;
        $this->handler = $handler;
        $this->counter = $counter;
    }

    public function handle(Request $request, Response $response, array $args = []): Response
    {
        /**
         * @psalm-var string[] $data
         * @psalm-suppress MixedArrayAccess
         */
        $data = $args;
        $command = new Command();
        $command->id = $data['uuid'] ?? '';

        $this->validator->validate($command);
        $rows = $this->handler->handle($command);
        return $this->render(
            $request,
            $response,
            'juridical.twig',
            [
                'rows' => $rows,
                'command' => 'Обновить',
                'type' => 'juridical',
                'head' => 'Редактирование абонента',
                'action' => 'update',
                'urlPath' => $request->getUri()->getPath()
            ]
        );
    }
}
