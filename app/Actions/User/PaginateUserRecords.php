<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Http\Requests\User\IndexUserResquest;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateUserRecords
{
    /**
     * Faz a consulta e paginação dos registros dos usuários
     * 
     * @param IndexUserResquest $request
     * @return LengthAwarePaginator|false
     */
    public static function run (IndexUserResquest $request): LengthAwarePaginator | false
    {
        // Consulta os registros na base de dados
        $users = User::withTrashed()
            ->where('id', '!=', $request->user()->id)
            ->orderBy('name')
            ->paginate($request->validated('items') ?? 5);

        // Verifica se a paginação obteve resultados
        if ($users->isEmpty() && $request->validated('items') && $request->query('page')) {
            return false;
        }
        
        return $users;
    }
}