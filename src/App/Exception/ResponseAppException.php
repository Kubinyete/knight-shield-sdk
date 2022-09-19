<?php

namespace Kubinyete\KnightShieldSdk\App\Exception;

use Kubinyete\KnightShieldSdk\App\Response;
use Kubinyete\KnightShieldSdk\Shared\Trait\CanAssert;

class ResponseAppException extends ResponseException
{
    use CanAssert;

    public int $statusCode;
    public Response $response;

    public function __construct(int $statusCode, string $message, Response $response)
    {
        parent::__construct($message);

        $this->statusCode = $statusCode;
        $this->response = $response;
    }
}
