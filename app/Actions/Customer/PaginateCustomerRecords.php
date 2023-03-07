<?php

declare(strict_types=1);

namespace App\Actions\Customer;

use App\Http\Requests\Customer\IndexCustomerRequest;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateCustomerRecords
{
    private static function addSearchFilter(Builder $builder, string $search): void
    {
        $builder
            ->where('name', 'like', "%$search%")
            ->orWhere('cpf', '=', $search)
            ->orWhere('street', 'like', "%$search%");
    }

    /**
     * Faz a consulta e paginação dos registros dos usuários
     * 
     * @param IndexCustomerRequest $request
     * @return LengthAwarePaginator|false
     */
    public static function run(IndexCustomerRequest $request): LengthAwarePaginator | false
    {
        $customers = Customer::orderBy('name')
            ->when(
                $request->validated('search'),
                fn(Builder $builder, string $search) => self::addSearchFilter($builder, $search),
            )
            ->paginate($request->validated('items') ?? 20);

        if ($customers->isEmpty() && $request->validated('items') && $request->query('page')) {
            return false;
        }
        
        return $customers;
    }
}