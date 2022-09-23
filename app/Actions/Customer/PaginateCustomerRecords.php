<?php

declare(strict_types=1);

namespace App\Actions\Customer;

use App\Http\Requests\Customer\IndexCustomerRequest;
use App\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateCustomerRecords
{
    /**
     * Faz a consulta e paginação dos registros dos usuários
     * 
     * @param IndexCustomerRequest $request
     * @return LengthAwarePaginator|false
     */
    public static function run (IndexCustomerRequest $request): LengthAwarePaginator | false
    {
        $customers = Customer::orderBy('name')
            ->paginate($request->validated('items') ?? 20);

        if ($customers->isEmpty() && $request->validated('items') && $request->query('page')) {
            return false;
        }
        
        return $customers;
    }
}