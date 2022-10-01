<?php

declare(strict_types=1);

namespace App\Enums;

enum ReportType: string
{
    case PER_SELLER_FULL = 'per_seller_full';
    case PER_SELLER_SIMPLE = 'per_seller_simple';
}