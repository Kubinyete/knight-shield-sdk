<?php

namespace Kubinyete\KnightShieldSdk\Shared\Interface;

interface JsonUnserializable
{
    public static function fromJsonArray(array $json): self;
    public static function fromJsonString(string $json): self;
}
