<?php

declare(strict_types=1);

namespace App\Actions\Proposal;

use App\Enums\MainStatus;
use App\Models\Commission;
use App\Models\Configuration;
use App\Models\Proposal;

class GenerateCommissions
{
    private static function getProductCommission(Proposal $proposal): int
    {
        return $proposal
            ->product
            ->partners()
            ->firstWhere('partners.id', $proposal->partner_id)
            ->pivot
            ->commission;
    }

    public static function proposalIsApproved(Proposal $proposal): bool
    {
        return $proposal->status()->first(['main'])->main === MainStatus::APPROVED->value;
    }

    public static function run(Proposal $proposal): void
    {
        $product_commission = self::getProductCommission($proposal);
        $business_amount = $proposal->required_amount / 100 * $product_commission;
        // Comissão da empresa
        Commission::create([
            'proposal_id' => $proposal->id,
            'user_id' => null,
            'amount' => $business_amount,
            'percentage' => $product_commission,
        ]);
        // Comissão do vendedor
        $seller_commission = Configuration::first(['seller_commission'])->seller_commission;
        Commission::create([
            'proposal_id' => $proposal->id,
            'user_id' => $proposal->user_id,
            'amount' => $business_amount / 100 * $seller_commission,
            'percentage' => $seller_commission,
        ]);
    }
}