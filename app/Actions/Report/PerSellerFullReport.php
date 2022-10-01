<?php

declare(strict_types=1);

namespace App\Actions\Report;

use App\Enums\MainStatus;
use App\Support\CurrencyFormatter;
use Illuminate\Support\Facades\DB;

class PerSellerFullReport
{
    private function getData(array $data): array
    {
        $commissions = DB::select(<<<SQL
            SELECT
                p.id,
                u.name,
                u.id AS user_id,
                p.required_amount,
                c.percentage,
                c.amount,
                (SELECT amount FROM commissions WHERE proposal_id = p.id AND user_id IS NULL) AS business_amount,
                (SELECT percentage FROM commissions WHERE proposal_id = p.id AND user_id IS NULL) AS business_percentage
            FROM proposals p
                INNER JOIN statuses s on p.status_id = s.id
                INNER JOIN commissions c on p.id = c.proposal_id
                INNER JOIN users u on c.user_id = u.id
                WHERE s.main = ? AND
                    DATE(p.updated_at) BETWEEN ? AND ?;
            SQL,
            [
                MainStatus::APPROVED->value,
                $data['initial_date'],
                $data['final_date'],
            ],
        );
        $parsed_commissions = [];
        foreach ($commissions as $commission) {
            $user_id = $commission->user_id;
            if (! isset($parsed_commissions[$user_id])) {
                $parsed_commissions[$user_id] = [
                    'name' => $commission->name,
                    'proposals' => [],
                    'business_total' => 0,
                    'total' => 0,
                ];
            }

            $parsed_commissions[$user_id]['proposals'][] = [
                'id' => $commission->id,
                'required_amount' => CurrencyFormatter::format((float) $commission->required_amount),
                'business_percentage' => $commission->business_percentage,
                'business_amount' => CurrencyFormatter::format((float) $commission->business_amount),
                'percentage' => $commission->percentage,
                'amount' => CurrencyFormatter::format((float) $commission->amount),
            ];
            $parsed_commissions[$user_id]['business_total'] += (float) $commission->business_amount;
            $parsed_commissions[$user_id]['total'] += (float) $commission->amount;
        }

        $parsed_commissions = array_map(function($commission) {
            $commission['total'] = CurrencyFormatter::format($commission['total']);
            $commission['business_total'] = CurrencyFormatter::format($commission['business_total']);
            return $commission;
        }, $parsed_commissions);
        
        return [
            'title' => 'Relatório de Comissões por Vendedor (Completo)',
            'commissions' => $parsed_commissions,
        ];
    }
    public static function html(array $data): string
    {
        return view('reports.per_seller_full', (new static)->getData($data))->render();
    }
}