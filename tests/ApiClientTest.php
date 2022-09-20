<?php

namespace Tests;

use Kubinyete\KnightShieldSdk\App\Client;
use Kubinyete\KnightShieldSdk\App\ApiClient;
use Kubinyete\KnightShieldSdk\Domain\Auth\ApiToken;

class ApiClientTest extends TestCase
{
    public function testCanCallEndpointWithAuthenticatedToken()
    {
        $client = new ApiClient(new ApiToken(getenv('API_TOKEN')), ApiClient::SUPPORTED_API_VERSION_LATEST, ApiClient::DEFAULT_TIMEOUT_SECONDS, getenv('API_HOST'), getenv('API_PROTOCOL'), getenv('API_PORT'));
        $response = $client->getMe();
        $this->assertEquals(200, $response->getStatus());
    }
}
