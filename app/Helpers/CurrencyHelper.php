<?php

namespace App\Helpers;

final class CurrencyHelper
{
    // fake currency convert service
    /**
     * @param int $amount
     * @param string $from
     * @param string $to
     * @return array
     */
    public static function convert(int $amount, string $from, string $to): array
    {
        $rate = rand(1, 10) / 10;
        $convertedPrice = $amount * $rate;

        return [
            'rate' => $rate,
            'amount' => $convertedPrice,
        ];
    }
}
