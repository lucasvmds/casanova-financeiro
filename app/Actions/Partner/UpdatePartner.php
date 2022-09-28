<?php

declare(strict_types=1);

namespace App\Actions\Partner;

use App\Models\Partner;
use Illuminate\Support\Facades\DB;

class UpdatePartner
{
    public static function run(array $data, Partner $partner): void
    {
        DB::transaction(function() use($data, $partner) {
            $partner->update([
                'name' => $data['name'],
            ]);

            $partner_products_id = $partner->products()
                ->get(['products.id'])
                ->pluck('id')
                ->toArray();
            
            $partner->products()->detach(
                array_diff($partner_products_id, $data['products'] ?? [])
            );

            foreach ($data['products'] ?? [] as $product_id) {
                $partner->products()->updateExistingPivot(
                    $product_id,
                    [ 'commission' => $data['commissions'][$product_id], ],
                );
            }

            foreach (array_diff($data['products'] ?? [], $partner_products_id) as $product_id) {
                $partner->products()->attach($product_id, [
                    'commission' => $data['commissions'][$product_id],
                ]);
            }
        });
    }
}
