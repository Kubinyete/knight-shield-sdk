<?php

namespace Kubinyete\KnightShieldSdk\App\Exception;

use Kubinyete\KnightShieldSdk\App\Response;

class ResponseErrorException extends ResponseException
{
    public Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
        parent::__construct($this->getResponseMessage() ?? "An API error ocurred.");
    }

    public function getResponseMessage(): ?string
    {
        return $this->response->getMessage();
    }

    public function getResponseStatus(): ?int
    {
        return $this->response->getStatus();
    }

    public function getErrors(): array
    {
        return $this->response->getPath('errors');
    }
}
