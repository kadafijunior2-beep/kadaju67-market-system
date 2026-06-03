<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index()
    {
        return view('reports.index');
    }

    public function vendors(Request $request)
    {
        $filters = $request->only(['status', 'business_type', 'date_from', 'date_to']);
        $vendors = $this->reportService->getVendorReport($filters);

        if ($request->has('export')) {
            if ($request->export === 'pdf') {
                return $this->reportService->exportVendorsPdf($filters);
            }
        }

        return view('reports.vendors', compact('vendors', 'filters'));
    }

    public function stalls(Request $request)
    {
        $filters = $request->only(['status', 'location']);
        $stalls = $this->reportService->getStallReport($filters);

        return view('reports.stalls', compact('stalls', 'filters'));
    }

    public function revenue(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $report = $this->reportService->getRevenueReport($startDate, $endDate);

        if ($request->has('export')) {
            if ($request->export === 'pdf') {
                return $this->reportService->exportRevenuePdf($startDate, $endDate);
            }
        }

        return view('reports.revenue', compact('report', 'startDate', 'endDate'));
    }

    public function monthly(Request $request)
    {
        $year = $request->get('year', now()->year);
        $report = $this->reportService->getMonthlyReport($year);

        if ($request->has('export')) {
            if ($request->export === 'pdf') {
                return $this->reportService->exportMonthlyPdf($year);
            }
        }

        return view('reports.monthly', compact('report'));
    }
}
