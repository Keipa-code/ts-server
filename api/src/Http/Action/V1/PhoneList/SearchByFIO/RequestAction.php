<?php

namespace App\Http\Action\V1\PhoneList\SearchByFIO;

use App\Http\BaseAction;
use App\Http\Service\Link;
use App\Http\Service\PageCounter;
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
    /**
     * @var PageCounter
     */
    private PageCounter $counter;

    public function __construct(
        Handler $handler,
        Validator $validator,
        ContainerInterface $container,
        PageCounter $counter
    ) {
        parent::__construct($container);
        $this->handler = $handler;
        $this->validator = $validator;
        $this->counter = $counter;
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
        //$this->logger->warning();
        $command = new Command();

        if (isset($data['fio'])) {
            $command->fio = mb_strtolower($data['fio']);
            $pageCount = $this->counter->pageCountByFIO($command->fio);
        }
        if (isset($data['organizationName'])) {
            $command->organizationName = mb_strtolower($data['organizationName']);
            $pageCount = $this->counter->pageCountByOrgName($command->organizationName);
        }
        $command->phonenumber = $data['phonenumber']  ?? '';
        $command->order = $data['order']  ?? 'ASC';
        $command->pageNumber = (isset($data['page'])) ? intval($data['page']) : 1;
        if (isset($data['sort'])) {
            if ($data['sort'] == 'number') {
                $command->sort = 'n.phonenumber.number';
            } elseif ($data['sort'] == 'name') {
                $command->sort = 'name';
            }
        } else {
            $command->sort = '';
        }
        $this->validator->validate($command);
        $list = $this->handler->handle($command, $this->logger);
        $link = Link::generateSortLink($data);
        return $this->render(
            $request,
            $response,
            'list.twig',
            [
                'list' => $list,
                'fio' => isset($data['fio']) ? ($data['fio']) : '',
                'phonenumber' => isset($data['phonenumber']) ? ($data['phonenumber']) : '',
                'orgName' => isset($data['organizationName']) ? ($data['organizationName']) : '',
                'total' => $pageCount,
                'current' => $data['page'] ?? 1,
                'url' => "list?" . http_build_query($data) . '&page=',
                'numberSort' => $link['number'],
                'nameSort' => $link['name']
            ]
        );
    }
}
