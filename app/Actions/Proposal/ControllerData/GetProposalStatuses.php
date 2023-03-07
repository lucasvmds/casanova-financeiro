<?php

declare(strict_types=1);

namespace App\Actions\Proposal\ControllerData;

use App\Models\Proposal;
use Illuminate\Database\Eloquent\Collection;

class GetProposalStatuses
{
    public static function get(Proposal $proposal): Collection
    {
        return $proposal->statuses()
            ->withTrashed()
            ->orderByPivot('created_at', 'desc')
            ->get(['name', 'color']);
    }
}