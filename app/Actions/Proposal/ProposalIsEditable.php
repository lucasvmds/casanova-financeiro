<?php

declare(strict_types=1);

namespace App\Actions\Proposal;

use App\Enums\MainStatus;
use App\Models\Proposal;

class ProposalIsEditable
{
    public static function run(Proposal $proposal): bool
    {
        return $proposal->status()->first(['main'])->main === MainStatus::OPEN->value;
    }
}