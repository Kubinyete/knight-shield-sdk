<?php

namespace Tests;

use Kubinyete\KnightShieldSdk\App\Client;
use Kubinyete\KnightShieldSdk\App\ApiClient;
use Kubinyete\KnightShieldSdk\Domain\Auth\ApiToken;

class ApiClientTest extends TestCase
{
    public function testCanCallEndpointWithAuthenticatedToken()
    {
        $client = new ApiClient(new ApiToken(getenv('API_TOKEN')));
        $response = $client->getMe();
        $this->assertEquals(200, $response->getStatus());
    }
}
