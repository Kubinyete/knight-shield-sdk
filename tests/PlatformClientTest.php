<?php

namespace Tests;

use Kubinyete\KnightShieldSdk\App\Client;
use Kubinyete\KnightShieldSdk\App\PlatformClient;

class PlatformClientTest extends TestCase
{
    public function testCanCallEndpoint()
    {
        $client = new PlatformClient();
        $response = $client->about();
        $this->assertEquals(200, $response->getStatus());
    }
}
