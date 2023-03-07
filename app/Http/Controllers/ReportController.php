<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Report\GenerateReport;
use App\Actions\Report\GenerateReportUrl;
use App\Http\Requests\Report\ReportRequest;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index(): \Inertia\Response
    {
        $this->authorize('index', ReportController::class);
        return Inertia::render('Report/Index', [
            'url' => session('report_url'),
        ]);
    }

    public function url(ReportRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('url', ReportController::class);
        GenerateReportUrl::run($request->validated());
        return redirect()->route('reports.index');
    }

    public function generate(ReportRequest $request): \Illuminate\Http\Response
    {
        $this->authorize('generate', ReportController::class);
        return response(
            content: GenerateReport::run($request->validated()),
            headers: [
                'Content-Type' => 'application/pdf',
            ],
        );
    }
}
