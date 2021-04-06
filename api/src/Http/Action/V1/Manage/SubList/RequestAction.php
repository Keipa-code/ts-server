<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Manage\SubList;

use App\Http\BaseAction;
use App\Http\Validator\Validator;
use App\Manage\Command\ListSubscriber\Request\Command;
use App\Manage\Command\ListSubscriber\Request\Handler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RequestAction extends BaseAction
{
    private Validator $validator;
    private Handler $handler;

    public function __construct(Handler $handler, Validator $validator, ContainerInterface $container)
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
        $data = $request->getQueryParams();
        //$data = $args;
        $command = new Command();
        $command->fio = mb_strtolower($data['fio']) ?? '';
        $command->phonenumber = $data['phonenumber']  ?? '';
        $command->organizationName = mb_strtolower($data['organizationName'])  ?? '';
        $command->order = $data['order']  ?? 'ASC';
        $command->pageNumber = intval($data['page'])  ?? 1;
        if ($data['sort'] == 'number'){
            $command->sort = 'n.phonenumber.number';
        }elseif ($data['sort'] == 'name') {
            $command->sort = 'p.surname';
        }

        $this->validator->validate($command);

        $list = $this->handler->handle($command);
        //$this->logger->warning($numbers['0']->getPhonenumbers()['0']->getFormattedNumber());
        return $this->render(
            $request,
            $response,
            'manage.twig',
            [
                'list' => $list,
                'fio' => $data['fio'],
                'phonenumber' => $data['phonenumber'],
                'organizationName' => $data['organizationName'],
                'order'
            ]);
    }
}
