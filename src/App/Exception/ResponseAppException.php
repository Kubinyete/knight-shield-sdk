<?php

namespace Kubinyete\KnightShieldSdk\App\Exception;

use Kubinyete\KnightShieldSdk\App\Response;

class ResponseAppException extends ResponseException
{
    public int $statusCode;
    public Response $response;

    public function __construct(int $statusCode, string $message, Response $response)
    {
        parent::__construct($message);

        $this->statusCode = $statusCode;
        $this->response = $response;
    }
}
