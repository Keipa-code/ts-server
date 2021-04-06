<?php

namespace App\Http\Action\V1\PhoneList\SearchByFIO;

use App\Http\BaseAction;
use App\Http\Service\Link;
use App\Http\Validator\Validator;
use App\PhoneList\Command\SearchByFIO\Command;
use App\PhoneList\Command\SearchByFIO\Handler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RequestAction extends BaseAction
{
    private Handler $handler;
    private Validator $validator;

    public function __construct(Handler $handler, Validator $validator, ContainerInterface $container)
    {
        parent::__construct($container);
        $this->handler = $handler;
        $this->validator = $validator;
    }

    public function index(Request $request, Response $response, array $args = []): Response
    {
        $this->logger->info("Home page action dispatched");

        return $this->render($request, $response, 'index.twig');
    }

    public function handle(Request $request, Response $response, array $args = []): Response
    {
        /**
         * @psalm-var string[] $data
         * @psalm-suppress MixedArrayAccess
         */
        $data = $request->getQueryParams();
        //$this->logger->warning("list?" . http_build_query($data));
        $command = new Command();
        $link = new Link();
        $command->fio = mb_strtolower($data['fio']) ?? '';
        $command->phonenumber = $data['phonenumber']  ?? '';
        $command->organizationName = mb_strtolower($data['organizationName'])  ?? '';

        $this->validator->validate($command);

        $list = $this->handler->handle($command, $this->logger);

        return $this->render(
            $request,
            $response,
            'list.twig',
            [
                'list' => $list,
                'fio' => $data['fio'],
                'phonenumber' => $data['phonenumber'],
                'organizationName' => $data['organizationName'],
                'total' => 2,//$link->pageCount($list),
                'current' => $data['page'] ?? 1,
                'url' => "list?" . http_build_query($data)
            ]);
    }
}