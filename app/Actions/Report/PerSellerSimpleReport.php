<?php

declare(strict_types=1);

namespace App\Actions\Report;

use App\Enums\MainStatus;
use App\Support\CurrencyFormatter;
use Illuminate\Support\Facades\DB;

class PerSellerSimpleReport
{
    private function getData(array $data): array
    {
        $commissions = (array) DB::select(<<<SQL
            SELECT
                u.id,
                u.name,
                SUM(c.amount) AS amount
            FROM proposals p
                INNER JOIN statuses s on p.status_id = s.id
                INNER JOIN commissions c on p.id = c.proposal_id
                INNER JOIN users u on c.user_id = u.id
                WHERE s.main = ? AND
                    p.updated_at BETWEEN ? AND ?
                GROUP BY u.name, u.id;
            SQL,
            [
                MainStatus::APPROVED->value,
                $data['initial_date'],
                $data['final_date'],
            ],
        );

        $commissions = array_map(function($commission) {
            $commission->amount = CurrencyFormatter::format((float) $commission->amount);
            return $commission;
        }, $commissions);
        
        return [
            'title' => 'Relatório de Comissões por Vendedor (Simples)',
            'commissions' => $commissions,
        ];
    }
    public static function html(array $data): string
    {
        return view('reports.per_seller_simple', (new static)->getData($data))->render();
    }
}