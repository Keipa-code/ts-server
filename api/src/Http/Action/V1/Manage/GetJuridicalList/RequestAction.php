<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Manage\GetJuridicalList;

use App\Http\BaseAction;
use App\Http\Service\Link;
use App\Http\Service\PageCounter;
use App\Http\Validator\Validator;
use App\Manage\Command\GetJuridicalList\Command;
use App\Manage\Command\GetJuridicalList\Handler;
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
        $data = $request->getQueryParams();
        //$data = $args;
        $command = new Command();
        if (isset($data['name'])) {
            $command->organizationName = trim(mb_strtolower($data['name']));
            $pageCount = $this->counter->pageCountByOrgName($command->organizationName);
        } elseif (isset($data['phonenumber'])) {
            $command->phonenumber = trim($data['phonenumber']);
            $pageCount = 1;
        } else {
            $pageCount = $this->counter->pageCountJuridical();
        }
        $command->order = $data['order'] ?? 'ASC';
        $command->pageNumber = isset($data['page']) ? intval($data['page']) : 1;
        //$command->subscriberType = $data['type'] ?? 'private';
        if (isset($data['sort'])) {
            if ($data['sort'] == 'number') {
                $command->sort = 'n.phonenumber.number';
            } elseif ($data['sort'] == 'name') {
                $command->sort = 'p.organizationName';
            }
        }
        $this->validator->validate($command);
        $link = Link::generateSortLink($data);
        $list = $this->handler->handle($command);
        //$this->logger->warning($numbers['0']->getPhonenumbers()['0']->getFormattedNumber());
        return $this->render(
            $request,
            $response,
            'manage.twig',
            [
                'list' => $list,
                'value' => $data['name'] ?? '',
                'placeholder' => 'Наименование организации',
                'phonenumber' => $data['phonenumber'] ?? '',
                'type' => 'juridical',
                'total' => $pageCount,
                'current' => $data['page'] ?? 1,
                'url' => "juridical?" . http_build_query($data) . '&page=',
                'numberSort' => $link['number'],
                'nameSort' => $link['name'],
                'urlForButton' => 'editJuridical',
                'addButton' => 'addJuridical'
            ]
        );
    }
}
