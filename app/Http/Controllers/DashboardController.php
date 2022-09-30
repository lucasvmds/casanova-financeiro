<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Dashboard\GetLastActivities;
use App\Actions\Dashboard\GetMostActives;
use App\Actions\Dashboard\GetNumbers;
use App\Enums\UserGroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request): \Inertia\Response | \Illuminate\Http\RedirectResponse
    {
        if ($request->user()->group === UserGroup::SELLER->value) return redirect()->route('proposals.index');
        return Inertia::render('Dashboard/Index');
    }

    public function activities(Request $request): \Illuminate\Support\Collection
    {
        return GetLastActivities::get($request);
    }

    public function actives(): array
    {
        return [
            'partners' => GetMostActives::partners(),
            'products' => GetMostActives::products(),
            'sellers' => GetMostActives::users(),
        ];
    }

    public function numbers(): array
    {
        return [
            'proposals' => GetNumbers::proposals(),
            'approved_amount' => GetNumbers::approvedAmount(),
            'business_commission' => GetNumbers::businessCommission(),
        ];
    }
}
