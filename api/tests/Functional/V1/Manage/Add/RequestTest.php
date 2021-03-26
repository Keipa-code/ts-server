<?php


namespace Test\Functional\V1\Manage\Add;


use Test\Functional\Json;
use Test\Functional\WebTestCase;

class RequestTest extends WebTestCase
{
    public function testMethod(): void
    {
        $response = $this->app()->handle(self::json('GET', '/v1/manage/add'));

        self::assertEquals(405, $response->getStatusCode());
    }

    public function testSuccess(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/manage/add', [
            'phoneNumber' => '87775554444',
            'subType' => 'private',
            'private' => [
                'firstname' => 'Ivan',
                'surname' => 'Ivanov',
                'patronymic' => 'Ivanovich',
                ]
            ]));

        self::assertEquals(201, $response->getStatusCode());
        self::assertEquals('{}', (string)$response->getBody());

    }

    public function testExisting(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/manage/add', [
            'phoneNumber' => '87775554444',
            'subType' => 'private',
            'private' => [
                'firstname' => 'Ivan',
                'surname' => 'Ivanov',
                'patronymic' => 'Ivanovich',
                ]
            ]));

        self::assertEquals(409, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            'message' => 'User already exists.',
        ], Json::decode($body));
    }

    public function testExistingLang(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/manage/add', [
            'phoneNumber' => '87775554444',
            'subType' => 'private',
            'private' => [
                'firstname' => 'Ivan',
                'surname' => 'Ivanov',
                'patronymic' => 'Ivanovich',
            ]
        ])->withHeader('Accept-Language', 'ru'));

        self::assertEquals(409, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        $data = Json::decode($body);

        self::assertEquals([
            'message' => 'Пользователь уже существует.',
        ], $data);
    }

    public function testEmpty(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/manage/add', []));

        self::assertEquals(422, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            'errors' => [
                'email' => 'This value should not be blank.',
                'password' => 'This value should not be blank.',
            ],
        ], Json::decode($body));
    }

    public function testNotValid(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/manage/add', [
            'email' => 'not-email',
            'password' => '',
        ]));

        self::assertEquals(422, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            'errors' => [
                'email' => 'This value is not a valid email address.',
                'password' => 'This value should not be blank.',
            ],
        ], Json::decode($body));
    }

    public function testNotValidLang(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/manage/add', [
            'email' => 'not-email',
            'password' => '',
        ])->withHeader('Accept-Language', 'es;q=0.9, ru;q=0.8, *;q=0.5'));

        self::assertEquals(422, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        $data = Json::decode($body);

        self::assertEquals([
            'errors' => [
                'email' => 'Значение адреса электронной почты недопустимо.',
                'password' => 'Значение не должно быть пустым.',
            ],
        ], $data);
    }
}