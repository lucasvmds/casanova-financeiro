<?php

declare(strict_types=1);

namespace App\Actions\Report;

use Dompdf\Dompdf;

class GenerateReport
{
    public static function run(array $data): string
    {
        $html = match($data['report_type']) {
            'per_seller_full' => PerSellerFullReport::html($data),
            'per_seller_simple' => PerSellerSimpleReport::html($data),
        };
        $pdf = new Dompdf;
        $pdf->setPaper('A4');
        $pdf->loadHtml($html);
        $pdf->render();
        return $pdf->output();
    }
}