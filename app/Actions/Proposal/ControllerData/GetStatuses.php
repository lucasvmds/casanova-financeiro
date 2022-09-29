<?php

declare(strict_types=1);

namespace App\Actions\Proposal\ControllerData;

use App\Actions\Proposal\ProposalIsEditable;
use App\Models\Proposal;
use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;

class GetStatuses
{
    public static function get(Proposal $proposal): Collection
    {
        if (ProposalIsEditable::run($proposal)) {
            return Status::orderBy('name')
                ->get([
                    'id',
                    'name',
                    'color',
                ]);
        } else {
            return Status::withTrashed()
                ->orderBy('name')
                ->get([
                    'id',
                    'name',
                    'color',
                ]);
        }
    }
}