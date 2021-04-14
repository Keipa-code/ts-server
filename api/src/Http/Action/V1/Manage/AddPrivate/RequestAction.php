<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Manage\AddPrivate;

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

    public function __construct(
        ContainerInterface $container
    ) {
        parent::__construct($container);
    }

    public function handle(Request $request, Response $response): Response
    {

        return $this->render(
            $request,
            $response,
            'private.twig',
            [
                'type' => 'private',
                'head' => 'Добавление абонента - Физическое лицо',
                'action' => 'add',
                'command' => 'Добавить',
                'urlPath' => $request->getUri()->getPath()
            ]
        );
    }
}
