<?php

namespace Kubinyete\KnightShieldSdk\App;

use Kubinyete\KnightShieldSdk\Domain\Auth\PlatformToken;

class PlatformClient extends Client
{
    public function __construct(float $timeout = self::DEFAULT_TIMEOUT_SECONDS)
    {
        parent::__construct(null, $timeout);
    }

    protected function path(string $relativePath = ''): string
    {
        $relativePath = ltrim($relativePath, '/');
        return parent::path("api/{$relativePath}");
    }

    public function about(): Response
    {
        return $this->request('GET', '/');
    }

    public function authenticate(string $username, string $password): Response
    {
        return $this->request('POST', '/authenticate', [], [], compact('username', 'password'));
    }

    public function me(): Response
    {
        return $this->request('GET', '/me');
    }
}
