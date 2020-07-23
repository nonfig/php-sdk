<?php

use Codeception\Stub\Expected;
use Httpful\Httpful;
use Httpful\Request;

require 'vendor/autoload.php';
require "index.php";

const APP_ID = "fake app";
const APP_SECRET = "fake secret";
const BASE_URL = "https://app.nonfig.com";

class NonfigTest extends \Codeception\Test\Unit
{

    protected function _before()
    {
    }

    protected function _after()
    {

    }

    // tests
    public function testConstructorShouldSetProperties() {
        $nonfig = new Nonfig(APP_ID, APP_SECRET);

        $this->assertEquals(APP_ID, $nonfig->appId);
        $this->assertEquals(APP_SECRET, $nonfig->appSecret);
        $this->assertEquals(BASE_URL, $nonfig->baseUrl);
        $this->assertEquals(BASE_URL . '/api/v1', $nonfig->apiUrl);

    }

    public function testFindConfigurationByName() {
        $fakeData = (object)[
            'id' => 'fake-id',
            'type' => 'JSON',
            'data' => ''
        ];

        $response = (object) [
            'body' => (object) [
                'statusCode' => 200,
                'data' => [$fakeData]
            ]
        ];

        $nonfig = $this->construct(
            Nonfig::class,
            [APP_ID, APP_SECRET],
            [
                'executeRequest' => $response
            ]
        );

        $name = 'fake-name';
        $config = $nonfig->findConfigurationByName($name);

        $this->assertEquals('fake-id', $config->id);
        $this->assertEquals('JSON', $config->type);
    }
}
