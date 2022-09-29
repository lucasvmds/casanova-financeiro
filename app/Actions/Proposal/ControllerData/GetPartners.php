<?php

declare(strict_types=1);

namespace App\Actions\Proposal\ControllerData;

use App\Actions\Proposal\ProposalIsEditable;
use App\Models\Product;
use App\Models\Proposal;
use Illuminate\Database\Eloquent\Collection;

class GetPartners
{
    public static function get(Proposal $proposal): Collection
    {
        if (ProposalIsEditable::run($proposal)) {
            return Product::find($proposal->product_id)
                ->partners()
                ->orderBy('name')
                ->get(['partners.id', 'partners.name']);
        } else {
            return Product::withTrashed()
                ->find($proposal->product_id)
                ->partners()
                ->withTrashed()
                ->orderBy('name')
                ->get(['partners.id', 'partners.name']);
        }
    }
}