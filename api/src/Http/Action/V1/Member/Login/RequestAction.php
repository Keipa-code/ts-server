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
use Slim\Routing\RouteContext;
use Symfony\Component\HttpFoundation\Session\Session;

class RequestAction extends BaseAction
{
    private Handler $handler;
    private Validator $validator;
    private ContainerInterface $container;
    private Session $session;

    public function __construct(
        Handler $handler,
        Validator $validator,
        ContainerInterface $container,
        Session $session
    )
    {
        parent::__construct($container);
        $this->handler = $handler;
        $this->validator = $validator;
        $this->container = $container;
        $this->session = $session;
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

                return $response->withStatus(302)->withHeader('Location', '/member/login');
            }
            $command = new Command();
            $command->username = (string)($data['uname'] ?? '');
            $command->password = (string)($data['pswd'] ?? '');

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();

            $flash = $this->session->getFlashBag();
            $flash->clear();

            $uinfo = $this->handler->handle($command);

            if ($uinfo == false) {
                $flash->set('error', 'Login failed!');
                $url = $routeParser->urlFor('login');
                return $response->withStatus(302)->withHeader('Location', $url);
            }

            $this->session->invalidate();
            $this->session->start();
            $url = $routeParser->urlFor('manage');
            $this->session->set('user', $uinfo->getUserName());
            $flash->set('success', 'Login successfully');
            return $response->withStatus(302)->withHeader('Location', $url);
        }

        return $this->render(
            $request,
            $response,
            'login.twig',
            [
                'flash' => $this->session->getFlashBag()->get('info'),
                'uinfo' => $request->getAttribute('uinfo')
            ]);
    }
}