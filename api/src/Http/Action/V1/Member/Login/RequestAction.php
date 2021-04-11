<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Member\Login;

use App\Auth\Command\SignIn\Command;
use App\Auth\Command\SignIn\Handler;
use App\Http\BaseAction;
use App\Http\Validator\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Flash\Messages;
use Slim\Routing\RouteContext;
use Symfony\Component\HttpFoundation\Session\Session;

class RequestAction extends BaseAction
{
    private Handler $handler;
    private Session $session;
    private Messages $flash;

    public function __construct(
        Handler $handler,
        ContainerInterface $container,
        Session $session
    ) {
        parent::__construct($container);
        $this->handler = $handler;
        $this->session = $session;
        $this->flash = $container->get(Messages::class);
    }

    public function handle(Request $request, Response $response): Response
    {
        if ($request->getMethod() == 'POST') {
            /**
             * @psalm-var string[] $data
             * @psalm-suppress MixedArrayAccess
             */
            $data = $request->getParsedBody();

            if (empty($data["uname"]) || empty($data["pswd"])) {
                return $response->withStatus(302)->withHeader('Location', '/v1/login');
            }
            $command = new Command();
            $command->username = (string)($data['uname'] ?? '');
            $command->password = (string)($data['pswd'] ?? '');

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();

            $uinfo = $this->handler->handle($command);

            if ($uinfo == false) {
                $this->flash->addMessage('danger', 'Неверно введены имя пользователя или пароль');
                $url = $routeParser->urlFor('login');
                return $response->withStatus(302)->withHeader('Location', $url);
            }

            $this->session->invalidate();
            $this->session->start();
            $url = $routeParser->urlFor('manage');
            $this->session->set('user', $uinfo->getUserName());
            $this->flash->addMessage('success', 'Login successfully');
            return $response->withStatus(302)->withHeader('Location', $url);
        }

        return $this->render(
            $request,
            $response,
            'login.twig',
            [
                //'flash' => $this->flash->getMessage('info'),
                'uinfo' => $request->getAttribute('uinfo')
            ]
        );
    }
}
