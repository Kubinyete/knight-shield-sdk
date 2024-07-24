<?php

namespace Kubinyete\KnightShieldSdk\Domain\Person;

use Stringable;
use Kubinyete\KnightShieldSdk\Shared\Exception\DomainException;

class Cnpj implements Stringable
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
        $raw = str_pad($raw, 14, '0', STR_PAD_LEFT);
        DomainException::assert(mb_strlen($raw), "CNPJ must be 11 characters long after sanetization");

        $split = str_split($raw);
        $initial = $split[0];
        DomainException::assert(array_reduce($split, fn ($prev, $curr) => $curr != $initial ? $curr : $prev, $initial) != $initial, "CNPJ should not have all digits be equal to each other");

        $j = 5;
        $k = 6;
        $soma1 = 0;
        $soma2 = 0;

        for ($i = 0; $i < 13; $i++) {
            $j = $j == 1 ? 9 : $j;
            $k = $k == 1 ? 9 : $k;

            $soma2 += ($raw[$i] * $k);

            if ($i < 12) {
                $soma1 += ($raw[$i] * $j);
            }

            $k--;
            $j--;
        }

        $digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
        $digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;

        DomainException::assert((($raw[12] == $digito1) and ($raw[13] == $digito2)), "CNPJ validation failed");

        $p1 = substr($raw, 0, 2);
        $p2 = substr($raw, 2, 3);
        $p3 = substr($raw, 5, 3);
        $p4 = substr($raw, 8, 4);
        $p5 = substr($raw, 12, 2);

        return "$p1.$p2.$p3/$p4-$p5";
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
