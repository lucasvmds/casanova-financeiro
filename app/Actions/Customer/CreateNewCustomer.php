<?php

declare(strict_types=1);

namespace App\Actions\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CreateNewCustomer
{
    public static function run(array $data): void
    {
        DB::transaction(function() use($data) {
            $contacts = $data['contacts'];
            unset($data['contacts']);
            $customer = Customer::create($data);
            $customer->contacts()->createMany($contacts);
        });
    }
}