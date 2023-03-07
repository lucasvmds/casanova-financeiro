<?php

declare(strict_types=1);

namespace App\Actions\Dashboard;

use App\Enums\MainStatus;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GetMostActives
{
    private const RELATED_TABLE_FIELDS = [
        'partners' => 'partner_id',
        'products' => 'product_id',
        'users' => 'user_id',
    ];

    private static function getDefaultQuery(string $table, bool $withStatusFilter = false): Builder
    {
        return DB::table($table)
            ->select([
                "$table.name",
                DB::raw("COUNT($table.id) AS `number`"),
            ])
            ->join('proposals', "$table.id", '=', 'proposals.'.self::RELATED_TABLE_FIELDS[$table])
            ->groupBy("$table.name")
            ->orderBy('number', 'desc')
            ->take(3)
            ->when(
                $withStatusFilter,
                fn(Builder $builder) => $builder->join('statuses', 'statuses.id', '=', 'proposals.status_id')
                                                ->where('statuses.main', MainStatus::APPROVED->value),
            );
    }

    public static function partners(): Collection
    {
        return self::getDefaultQuery('partners', true)
            ->get();
    }

    public static function products(): Collection
    {
        return self::getDefaultQuery('products')
            ->get();
    }

    public static function users(): Collection
    {
        return self::getDefaultQuery('users', true)
            ->get();
    }
}