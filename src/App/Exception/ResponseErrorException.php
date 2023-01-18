<?php

namespace Kubinyete\KnightShieldSdk\App\Exception;

use Kubinyete\KnightShieldSdk\App\Response;

class ResponseErrorException extends ResponseException
{
    public Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;

        $errorStr = $this->getErrorsString();
        $errorMessage = $this->getResponseMessage();

        parent::__construct(($errorMessage ?? "An API error ocurred.") . ($errorStr ? ':' . PHP_EOL . $errorStr : ''));
    }

    public function getResponseMessage(): ?string
    {
        return $this->response->getMessage();
    }

    public function getResponseStatus(): ?int
    {
        return $this->response->getStatus();
    }

    public function getErrors(): ?array
    {
        return $this->response->getPath('errors');
    }

    protected function getErrorsString(): string
    {
        $errors = $this->getErrors();
        $message = '';

        if ($errors) {
            foreach ($errors as $key => $value) {
                $message .= "{$key}: " . is_array($value) ? implode(', ', $value) : strval($value) . PHP_EOL;
            }
        }

        return $message;
    }
}
