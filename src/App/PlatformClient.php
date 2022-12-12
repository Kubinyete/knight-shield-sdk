<?php

namespace Kubinyete\KnightShieldSdk\App;

use Kubinyete\KnightShieldSdk\Domain\Auth\PlatformToken;

class PlatformClient extends Client
{
    public function __construct(?PlatformToken $token = null, float $timeout = self::DEFAULT_TIMEOUT_SECONDS, ?string $host = null, ?string $protocol = null, ?string $port = null)
    {
        parent::__construct($token, $timeout, $host, $protocol, $port);
    }

    protected function path(string $relativePath = ''): string
    {
        $relativePath = ltrim($relativePath, '/');
        return parent::path("api/{$relativePath}");
    }

    /**
     * @NOTE: Authentication
     */

    public function about(): Response
    {
        return $this->request('GET', '/');
    }

    public function authenticate(string $username, string $password): PlatformToken
    {
        return new PlatformToken($this->request('POST', '/authenticate', [], [], compact('username', 'password'))->getResponsePath('access_token'));
    }

    public function me(): Response
    {
        return $this->request('GET', '/me');
    }

    /**
     * @NOTE: Merchants
     */

    public function getMerchants(int $page = 1, array $filters = []): Response
    {
        return $this->request('GET', '/merchants', compact('page') + $filters);
    }

    public function getMerchant(int $id): Response
    {
        return $this->request('GET', "/merchants/{$id}");
    }

    public function createMerchant(array $body): Response
    {
        return $this->request('POST', "/merchants", [], [], $body);
    }

    public function createMerchantBatch(array $body): Response
    {
        return $this->request('POST', "/merchants/batch", [], [], $body);
    }

    public function updateMerchant(int $id, array $body): Response
    {
        return $this->request('PATCH', "/merchants/{$id}", [], [], $body);
    }

    public function deleteMerchant(int $id, array $body): Response
    {
        return $this->request('DELETE', "/merchants/{$id}", [], [], $body);
    }

    /**
     * @NOTE: Merchant Tokens
     */

    public function getMerchantTokens(int $id, int $page = 1, array $filters = []): Response
    {
        return $this->request('GET', "/merchants/{$id}/tokens", compact('page') + $filters);
    }

    public function createMerchantToken(int $id, string $name): Response
    {
        return $this->request('POST', "/merchants/{$id}/tokens", [], [], ['name' => $name]);
    }

    public function clearMerchantTokens(int $id): Response
    {
        return $this->request('DELETE', "/merchants/{$id}/tokens");
    }

    /**
     * @NOTE: Merchant Methods
     */

    public function getMerchantMethods(int $id, int $page = 1, array $filters = []): Response
    {
        return $this->request('GET', "/merchants/{$id}/antifraud_methods", compact('page') + $filters);
    }

    public function addMerchantMethod(int $id, string $antifraudMethod, array $rules, array $config, int $order = 1): Response
    {
        return $this->request('POST', "/merchants/{$id}/antifraud_methods", [], [], [
            'uses' => $antifraudMethod,
            'order' => $order,
            'with' => [
                'rules' => $rules,
                'config' => $config
            ]
        ]);
    }

    public function updateMerchantMethod(int $id, int $methodId, ?array $rules = null, ?array $config = null, bool $isDisabled = false): Response
    {
        return $this->request('PATCH', "/merchants/{$id}/antifraud_methods/{$methodId}", [], [], [
            'is_disabled' => $isDisabled,
            'with' => [
                'rules' => $rules,
                'config' => $config
            ]
        ]);
    }

    public function removeMerchantMethod(int $id, int $methodId): Response
    {
        return $this->request('DELETE', "/merchants/{$id}/antifraud_methods/{$methodId}");
    }
}
