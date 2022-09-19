<?php

namespace Kubinyete\KnightShieldSdk\Shared\Interface;

interface JsonUnserializable
{
    public static function fromJsonArray(array $json): static;
    public static function fromJsonString(string $json): static;
}
