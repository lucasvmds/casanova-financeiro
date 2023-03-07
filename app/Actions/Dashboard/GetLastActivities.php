<?php

declare(strict_types=1);

namespace App\Actions\Dashboard;

use App\Enums\UserGroup;
use App\Models\Proposal;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class GetLastActivities
{
    public static function get(Request $request): Collection
    {
        return Proposal::orderBy('updated_at', 'desc')
            ->when(
                $request->user()->group === UserGroup::SELLER->value,
                fn(Builder $builder) => $builder->where('user_id', $request->user()->id),
            )
            ->take(5)
            ->get(
                columns: [
                    'id',
                    'customer_id',
                    'product_id',
                    'status_id',
                    'updated_at',
                ],
            )
            ->map(
                fn(Proposal $model) => $model->append([
                    'current_status',
                    'customer_name',
                ])
            );
    }
}