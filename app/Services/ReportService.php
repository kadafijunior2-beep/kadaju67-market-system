<?php

namespace App\Services;

use App\Models\Vendor;
use App\Models\Stall;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportService
{
    public function getVendorReport(array $filters = [])
    {
        $query = Vendor::withCount('payments')
            ->withSum('payments', 'amount');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['business_type'])) {
            $query->where('business_type', $filters['business_type']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('registration_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('registration_date', '<=', $filters['date_to']);
        }

        return $query->latest()->get();
    }

    public function getStallReport(array $filters = [])
    {
        $query = Stall::withCount('vendors');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['location'])) {
            $query->where('location', $filters['location']);
        }

        return $query->latest()->get();
    }

    public function getRevenueReport(string $startDate, string $endDate)
    {
        return Payment::where('status', 'completed')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->with('vendor')
            ->latest('payment_date')
            ->get();
    }

    public function getMonthlyReport(?int $year = null)
    {
        $year = $year ?? now()->year;

        $monthlyData = [];
        for ($month = 1; $month <= 12; $month++) {
            $revenue = Payment::where('status', 'completed')
                ->whereYear('payment_date', $year)
                ->whereMonth('payment_date', $month)
                ->sum('amount');

            $count = Payment::where('status', 'completed')
                ->whereYear('payment_date', $year)
                ->whereMonth('payment_date', $month)
                ->count();

            $monthlyData[] = [
                'month' => date('F', mktime(0, 0, 0, $month, 1)),
                'revenue' => $revenue,
                'count' => $count,
            ];
        }

        return [
            'year' => $year,
            'data' => $monthlyData,
            'total' => array_sum(array_column($monthlyData, 'revenue')),
        ];
    }

    public function exportVendorsPdf(array $filters = [])
    {
        $vendors = $this->getVendorReport($filters);

        $pdf = Pdf::loadView('reports.pdf.vendors', compact('vendors'));
        return $pdf->download('vendor-report-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportRevenuePdf(string $startDate, string $endDate)
    {
        $payments = $this->getRevenueReport($startDate, $endDate);
        $total = $payments->sum('amount');

        $pdf = Pdf::loadView('reports.pdf.revenue', compact('payments', 'total', 'startDate', 'endDate'));
        return $pdf->download('revenue-report-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportMonthlyPdf(?int $year = null)
    {
        $report = $this->getMonthlyReport($year);

        $pdf = Pdf::loadView('reports.pdf.monthly', compact('report'));
        return $pdf->download('monthly-report-' . ($year ?? now()->year) . '.pdf');
    }
}
