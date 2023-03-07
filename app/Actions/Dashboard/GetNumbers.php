<?php

declare(strict_types=1);

namespace App\Actions\Dashboard;

use App\Enums\MainStatus;
use App\Enums\UserGroup;
use App\Models\Commission;
use App\Support\CurrencyFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GetNumbers
{
    private static function getProposalsCountByStatus(MainStatus $status): int
    {
        return DB::table('proposals')
            ->join('statuses', 'statuses.id', '=', 'proposals.status_id')
            ->where('statuses.main', $status->value)
            ->count('proposals.id');
    }

    public static function proposals(): array
    {
        return [
            'approved' => self::getProposalsCountByStatus(MainStatus::APPROVED),
            'open' => self::getProposalsCountByStatus(MainStatus::OPEN),
            'closed' => self::getProposalsCountByStatus(MainStatus::CLOSED),
        ];
    }

    public static function approvedAmount(): string
    {
        return CurrencyFormatter::format(
            (float) DB::table('proposals')
                ->join('statuses', 'statuses.id', '=', 'proposals.status_id')
                ->where('statuses.main', MainStatus::APPROVED->value)
                ->sum('proposals.required_amount')
        );
    }

    public static function businessCommission(): string
    {
        return CurrencyFormatter::format(
            Auth::user()->group === UserGroup::ADMIN->value ?
                (float) Commission::whereNull('user_id')->sum('amount') :
                0
        );
    }
}