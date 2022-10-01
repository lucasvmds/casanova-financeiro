<?php

declare(strict_types=1);

namespace App\Actions\Report;

use Illuminate\Support\Facades\URL;

class GenerateReportUrl
{
    public static function run(array $data): void
    {
        session()->flash(
            'report_url',
            URL::temporarySignedRoute(
                'reports.generate',
                now()->addMinutes(30),
                $data,
            )
        );
    }
}