<?php

namespace Kubinyete\KnightShieldSdk\Shared\Trait;

use Kubinyete\KnightShieldSdk\Shared\Exception\UnserializeException;

trait CanUnserializeFromJsonString
{
    public static function fromJsonString(string $json): self
    {
        $parsedAssoc = json_decode($json, true);
        UnserializeException::assert($parsedAssoc !== null, "Failed to decode JSON");

        return static::fromJsonArray($parsedAssoc);
    }
}
