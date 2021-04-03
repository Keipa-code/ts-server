<?php

declare(strict_types=1);


namespace Test\Functional\V1\PhoneList\SearchByNumber;


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

    public function testSuccessPrivate(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/search', [
            'phonenumber' => '7770000005',
        ]));

        //self::assertEquals(200, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            'phonenumber' => '8 (777) 000 0005',
            'rowValue' => 'Baur Shuak Semba'
        ], Json::decode($body));
    }

    public function testSuccessJuridical(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/search', [
            'phonenumber' => '87770000006',
        ]));

        //self::assertEquals(200, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            'phonenumber' => '8 (777) 000 0006',
            'rowValue' => 'Uniserv priemnaya Kaz Oral Nekrasova 14'
        ], Json::decode($body));
    }
}