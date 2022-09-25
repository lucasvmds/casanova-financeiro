<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class UpdateProduct
{
    public static function run(array $data, Product $product): void
    {
        DB::transaction(function() use($data, $product) {
            $product->update([
                'name' => $data['name'],
                'commission' => $data['commission'],
            ]);

            $product_partners_id = $product->partners()
                ->get(['partners.id'])
                ->pluck('id')
                ->toArray();
            
            $product->partners()->detach(
                array_diff($product_partners_id, $data['partners'])
            );

            $product->partners()->attach(
                array_diff($data['partners'], $product_partners_id)
            );
        });
    }
}
