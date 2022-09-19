<?php

namespace Kubinyete\KnightShieldSdk\App;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Kubinyete\KnightShieldSdk\App\Exception\ResponseRuntimeException;
use Kubinyete\KnightShieldSdk\Domain\Auth\PlatformToken;
use Kubinyete\KnightShieldSdk\Domain\Auth\Token;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use ValueError;
use GuzzleHttp\Client as GuzzleClient;

abstract class Client
{
    protected const DEFAULT_USER_AGENT = 'KnightShieldSDK for PHP';
    protected const DEFAULT_EXPECTED_TYPE = 'application/json';

    protected const DEFAULT_HOST = 'ks.ipag.com.br';
    protected const DEFAULT_PROTOCOL = 'https';
    protected const DEFAULT_PORT = 443;

    protected const DEFAULT_TIMEOUT_SECONDS = 12;

    protected ?Token $token;
    protected float $timeout;

    public function __construct(
        ?Token $token,
        float $timeout,
    ) {
        $this->setToken($token);
        $this->setTimeout($timeout);
    }
    //

    public function setToken(?Token $token): void
    {
        $this->token = $token;
    }

    public function setTimeout(float $timeout): void
    {
        if ($timeout < 0) {
            throw new ValueError("Timeout cannot be a negative value.");
        }

        $this->timeout = $timeout;
    }

    //

    protected function path(string $relativePath = ''): string
    {
        $protocol = self::DEFAULT_PROTOCOL;
        $host = self::DEFAULT_HOST;
        $port = self::DEFAULT_PORT;

        $relativePath = ltrim($relativePath, '/');
        return "{$protocol}://{$host}:{$port}/{$relativePath}";
    }

    protected function request(string $method, string $path, array $query = [], array $headers = [], ?array $body = null): Response
    {
        $path = $this->path($path);

        $requestClient = new GuzzleClient([
            'headers' => array_merge([
                'User-Agent' => self::DEFAULT_USER_AGENT,
                'Accept' => self::DEFAULT_EXPECTED_TYPE,
                'Authorization' => 'Bearer ' . ($this->token ? $this->token->__toString() : ''),
            ], $headers),
            'timeout' => $this->timeout,
            'allow_redirects' => false,
        ]);

        try {
            $response = $requestClient->request($method, $path, ['json' => $body]);
            return $this->translateResponse($response);
        } catch (ClientException $e) {
            return $this->translateResponse($e->getResponse());
        } catch (GuzzleException $e) {
            ResponseRuntimeException::assert(false, "Failure while request endpoint [$path]: " . $e->getMessage());
        } catch (RuntimeException $e) {
            ResponseRuntimeException::assert(false, "Failure while reading response contents from endpoint [$path]: " . $e->getMessage());
        }
    }

    private function translateResponse(ResponseInterface $response): Response
    {
        $contents = $response->getBody()->getContents();
        return Response::createFrom($contents);
    }
}
