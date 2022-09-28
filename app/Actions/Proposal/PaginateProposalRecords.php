<?php

declare(strict_types=1);

namespace App\Actions\Proposal;

use App\Http\Requests\Proposal\IndexProposalRequest;
use App\Models\Proposal;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginateProposalRecords
{
    public static function run (IndexProposalRequest $request): LengthAwarePaginator | false
    {
        /** @var LengthAwarePaginator */
        $proposals = Proposal::orderBy('updated_at', 'desc')
            ->paginate($request->validated('items') ?? 20);

        if ($proposals->isEmpty() && $request->validated('items') && $request->query('page')) {
            return false;
        }

        return $proposals->setCollection(
            $proposals->getCollection()->map(
                fn($model) => $model->append([
                    'current_status',
                    'customer_name',
                    'product_name',
                ])
            )
        );
    }
}