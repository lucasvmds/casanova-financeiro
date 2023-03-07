<?php

declare(strict_types=1);

namespace App\Actions\Customer;

use App\Models\Customer;

class GetSearchResults
{
    public static function run(?string $search): \Illuminate\Support\Collection
    {
        return Customer::where('name', 'like', '%'.$search.'%')
            ->orWhere('cpf', '=', $search)
            ->get([
                'id',
                'name',
                'cpf',
                'state_id',
                'city_id',
            ]);
    }
}