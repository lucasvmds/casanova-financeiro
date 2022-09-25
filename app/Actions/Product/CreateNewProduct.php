<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CreateNewProduct
{
    public static function run(array $data): void
    {
        DB::transaction(function() use($data) {
            $product = Product::create([
                'name' => $data['name'],
                'commission' => $data['commission'],
            ]);

            $product->partners()->attach($data['partners']);
        });
    }
}