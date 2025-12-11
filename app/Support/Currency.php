<?php

namespace App\Support;

use Illuminate\Support\Arr;

class Currency
{
    public static function all(): array
    {
        return config('currencies.currencies', []);
    }

    public static function codes(): array
    {
        return array_keys(static::all());
    }

    public static function isSupported(string $currency): bool
    {
        return in_array(strtoupper($currency), static::codes(), true);
    }

    public static function exponent(string $currency): int
    {
        $config = Arr::get(static::all(), strtoupper($currency), []);
        return (int) ($config['exponent'] ?? 2);
    }

    public static function symbol(string $currency): string
    {
        $config = Arr::get(static::all(), strtoupper($currency), []);
        return (string) ($config['symbol'] ?? strtoupper($currency));
    }

    public static function toMinorUnits(float|int|string $value, string $currency): int
    {
        $currency = strtoupper($currency);
        $exponent = static::exponent($currency);

        $numeric = (float) $value;
        $factor = pow(10, $exponent);

        return (int) round($numeric * $factor);
    }

    public static function toMajorUnits(int $amount, string $currency): float
    {
        $currency = strtoupper($currency);
        $exponent = static::exponent($currency);

        if ($exponent === 0) {
            return (float) $amount;
        }

        return $amount / pow(10, $exponent);
    }

    public static function format(int $amount, string $currency): string
    {
        $currency = strtoupper($currency);
        $exponent = static::exponent($currency);
        $symbol = static::symbol($currency);

        if ($exponent === 0) {
            return trim(sprintf('%s %s', number_format($amount, 0, ',', ' '), $symbol));
        }

        $value = $amount / pow(10, $exponent);

        return trim(sprintf('%s %s', number_format($value, $exponent, ',', ' '), $symbol));
    }
}
