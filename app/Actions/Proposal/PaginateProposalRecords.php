<?php

declare(strict_types=1);

namespace App\Actions\Proposal;

use App\Enums\UserGroup;
use App\Http\Requests\Proposal\IndexProposalRequest;
use App\Models\Proposal;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateProposalRecords
{
    private static function addSearchFilter(Builder $builder, string $search): void
    {
        $builder
            ->join('customers', 'proposals.customer_id', '=', 'customers.id')
            ->where('customers.name', 'like', "%$search%")
            ->orWhere('customers.cpf', '=', $search)
            ->orWhere('proposals.id', '=', $search);
    }

    public static function run(IndexProposalRequest $request): LengthAwarePaginator | false
    {
        /** @var LengthAwarePaginator */
        $proposals = Proposal::orderBy('proposals.updated_at', 'desc')
            ->when(
                $request->user()->group === UserGroup::SELLER->value,
                fn(Builder $builder) => $builder->where('proposals.user_id', $request->user()->id),
            )
            ->when(
                $request->validated('search'),
                fn(Builder $builder, string $search) => self::addSearchFilter($builder, $search),
            )
            ->paginate(
                perPage: $request->validated('items') ?? 20,
                columns: [
                    'proposals.id',
                    'proposals.customer_id',
                    'proposals.product_id',
                    'proposals.status_id',
                    'proposals.user_id',
                    'proposals.created_at',
                    'proposals.updated_at',
                ],
            );

        if ($proposals->isEmpty() && $request->validated('items') && $request->query('page')) {
            return false;
        }

        return $proposals->setCollection(
            $proposals->getCollection()->map(
                fn(Proposal $model) => $model->append([
                    'current_status',
                    'customer_name',
                    'seller_name',
                ])
            )
        );
    }
}