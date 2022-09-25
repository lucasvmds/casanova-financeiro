<?php

declare(strict_types=1);

namespace App\Actions\Partner;

use App\Models\Partner;
use Illuminate\Support\Facades\DB;

class CreateNewPartner
{
    public static function run(array $data): void
    {
        DB::transaction(function() use($data) {
            $partner = Partner::create([
                'name' => $data['name'],
            ]);

            $partner->products()->attach($data['products']);
        });
    }
}