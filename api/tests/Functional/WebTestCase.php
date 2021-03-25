<?php

declare(strict_types=1);


namespace Test\Functional;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Psr7\Factory\ServerRequestFactory;

class WebTestCase extends TestCase
{
    protected static function json(string $method, string $path, array $body = []): ServerRequestInterface
    {
        $request =  self::request($method,$path)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json');
        $request->getBody()->write(json_encode($body, JSON_THROW_ON_ERROR));
        return $request;
    }

    protected static function request(string $method, string $path): ServerRequestInterface
    {
        return (new ServerRequestFactory())->createServerRequest($method, $path);
    }

    protected function app(): App
    {
        /** @var App */
        return (require __DIR__ . '/../../conf/app.php')($this->container());
    }

    protected function container(): ContainerInterface
    {
        /** @var ContainerInterface */
        return require __DIR__ . '/../../conf/container.php';
    }
}