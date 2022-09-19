<?php

namespace Kubinyete\KnightShieldSdk\App;

use JsonSerializable;
use Kubinyete\KnightShieldSdk\App\Exception\ResponseRuntimeException;
use Kubinyete\KnightShieldSdk\Shared\Util\ArrayUtil;

class Response implements JsonSerializable
{
    protected array $body;

    protected function __construct(
        array $body,
    ) {
        $this->body = $body;
    }

    public static function createFrom(mixed $body): static
    {
        if (!is_array($body)) {
            $body = json_decode(strval($body), true);
            ResponseRuntimeException::assert($body !== null && $body !== false);
        }

        return new static($body);
    }

    //

    public function getBody(): array
    {
        return $this->body;
    }

    public function getStatus(): int
    {
        return $this->getPath('status');
    }

    public function getMessage(): int
    {
        return $this->getPath('message');
    }

    public function getResponse(): mixed
    {
        return $this->getPath('response');
    }

    public function getPath(string $path): mixed
    {
        return ArrayUtil::get($path, $this->body);
    }

    public function getResponsePath(string $path): mixed
    {
        return ArrayUtil::get($path, $this->getResponse());
    }

    public function jsonSerialize()
    {
        return $this->body;
    }
}
