<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Manage\EditPrivate;

use App\Http\BaseAction;
use App\Http\Service\Link;
use App\Http\Service\PageCounter;
use App\Http\Validator\Validator;
use App\Manage\Command\Entity\Subscriber\Id;
use App\Manage\Command\GetById\Command;
use App\Manage\Command\GetById\Handler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RequestAction extends BaseAction
{
    private Validator $validator;
    private Handler $handler;

    public function __construct(
        Handler $handler,
        Validator $validator,
        ContainerInterface $container
    )
    {
        parent::__construct($container);
        $this->validator = $validator;
        $this->handler = $handler;
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
        //$this->logger->warning($numbers['0']->getPhonenumbers()['0']->getFormattedNumber());
        return $this->render(
            $request,
            $response,
            'private.twig',
            [
                'rows' => $rows,
                'command' => 'update',
                'type' => 'private',
                'head' => 'Редактирование абонента'
            ]);
    }
}
