<?php

declare(strict_types=1);

namespace App\Support;

use NumberFormatter;

class CurrencyFormatter
{
    public static function format(float $value): string | false
    {
        $formatter = new NumberFormatter('pt_BR', NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($value, 'BRL');
    }
}