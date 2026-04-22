<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\JsonResponse;

class ReportController extends BaseController
{
    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function incomeStatement(): JsonResponse
    {
        \Illuminate\Support\Facades\Gate::authorize('isAdmin');
        $report = $this->reportService->getIncomeStatement();
        return $this->responseJson($report, 'Income statement retrieved successfully.');
    }

    public function balanceSheet(): JsonResponse
    {
        \Illuminate\Support\Facades\Gate::authorize('isAdmin');
        $report = $this->reportService->getBalanceSheet();
        return $this->responseJson($report, 'Balance sheet retrieved successfully.');
    }
}
