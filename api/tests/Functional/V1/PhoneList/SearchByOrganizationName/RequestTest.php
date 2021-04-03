<?php

declare(strict_types=1);


namespace Test\Functional\V1\PhoneList\SearchByOrganizationName;


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

    public function testSuccess(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/search/orgname', [
            'organizationName' => 'uNiserv',
        ]));

        //self::assertEquals(200, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            '0' => ['phonenumber' => '8 (777) 000 0005', 'rowValue' => 'Uniserv priemnaya Kaz Oral Nekrasova 14 ']
        ], Json::decode($body));
    }

}