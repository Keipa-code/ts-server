<?php

declare(strict_types=1);

namespace Test\Functional\V1\PhoneList\SearchByFIO;

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
        $response = $this->app()->handle(self::json('POST', '/v1/search/fio', [
            'fio' => 'baur',
        ]));

        //self::assertEquals(200, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            '0' => ['phonenumber' => '8 (777) 000 0005', 'rowValue' => 'Baur Shuak Semba'],
            '1' => ['phonenumber' => '8 (777) 000 0006', 'rowValue' => 'Baur Awar Duma']
        ], Json::decode($body));
    }
}
