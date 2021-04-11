<?php

namespace Test\Functional\V1\Manage\Add;

use Test\Functional\V1\Manage\Add\RequestFixture;
use Test\Functional\Json;
use Test\Functional\WebTestCase;

class RequestTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures([
            RequestFixture::class,
        ]);
    }

    public function testMethod(): void
    {
        $response = $this->app()->handle(self::json('GET', '/v1/manage/add'));

        self::assertEquals(405, $response->getStatusCode());
    }

    public function testSuccess(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/manage/add', [
            'phoneNumber' => '87775554231',
            'subscriberType' => 'private',
            'firstname' => 'Ivan',
            'surname' => 'Ivanov',
            'patronymic' => 'Ivanovich',
        ]));

        self::assertEquals(201, $response->getStatusCode());
        self::assertEquals('', (string)$response->getBody());
    }

    public function testExisting(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/manage/add', [
            'phoneNumber' => '87770000001',
            'subscriberType' => 'private',
            'firstname' => 'Ivan',
            'surname' => 'Ivanov',
            'patronymic' => 'Ivanovich',
        ]));

        self::assertEquals(409, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            'message' => 'Phone number already exists.',
        ], Json::decode($body));
    }

    public function testEmpty(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/manage/add', []));

        self::assertEquals(422, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            'errors' => [
                'phoneNumber' => 'This value should not be blank.',
                'subscriberType' => 'Wrong value in type.',
            ]
        ], Json::decode($body));
    }

    public function testNotValid(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/manage/add', [
            'phoneNumber' => 'not-phone-number',
            'subscriberType' => 'not-type',
        ]));

        self::assertEquals(422, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            'errors' => [
                'phoneNumber' => 'This value is not valid.',
                'subscriberType' => 'Wrong value in type.',
            ]
        ], Json::decode($body));
    }
}
