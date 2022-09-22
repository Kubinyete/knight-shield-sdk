<?php

namespace Kubinyete\KnightShieldSdk\Domain\Person;

use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;
use Stringable;

class Cpf implements Stringable
{
    protected string $value;

    public function __construct(
        string $value
    ) {
        $this->value = $this->assertValueIsCorrect($value);
    }

    protected function assertValueIsCorrect(string $value): string
    {
        $raw = preg_replace('/[^0-9]/', '', $value);
        $raw = str_pad($raw, 11, '0', STR_PAD_LEFT);
        DomainException::assert(strlen($raw), "CPF must be 11 characters long after sanetization");

        $split = str_split($raw);
        $initial = $split[0];
        DomainException::assert(array_reduce($split, fn ($prev, $curr) => $curr != $initial ? $curr : $prev, $initial) != $initial, "CPF should not have all digits be equal to each other");

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $raw[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($raw[$c] != $d) {
                DomainException::assert(false, "CPF validation failed");
            }
        }

        $p1 = substr($raw, 0, 3);
        $p2 = substr($raw, 3, 3);
        $p3 = substr($raw, 6, 3);
        $p4 = substr($raw, 9, 2);

        return "$p1.$p2.$p3-$p4";
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
