<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Stall;
use App\Models\Payment;
use App\Models\ActivityLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_vendors' => Vendor::count(),
            'active_vendors' => Vendor::where('status', 'active')->count(),
            'total_stalls' => Stall::count(),
            'occupied_stalls' => Stall::where('status', 'occupied')->count(),
            'available_stalls' => Stall::where('status', 'available')->count(),
            'total_payments' => Payment::where('status', 'completed')->sum('amount'),
            'monthly_revenue' => Payment::where('status', 'completed')
                ->whereYear('payment_date', now()->year)
                ->whereMonth('payment_date', now()->month)
                ->sum('amount'),
            'pending_payments' => Payment::where('status', 'pending')->count(),
        ];

        $recentPayments = Payment::with('vendor')
            ->latest()
            ->take(5)
            ->get();

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(5)
            ->get();

        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyRevenue[] = [
                'month' => $date->format('M Y'),
                'revenue' => Payment::where('status', 'completed')
                    ->whereYear('payment_date', $date->year)
                    ->whereMonth('payment_date', $date->month)
                    ->sum('amount'),
            ];
        }

        $vendorStatusChart = [
            Vendor::where('status', 'active')->count(),
            Vendor::where('status', 'inactive')->count(),
            Vendor::where('status', 'suspended')->count(),
        ];

        return view('dashboard', compact(
            'stats',
            'recentPayments',
            'recentActivities',
            'monthlyRevenue',
            'vendorStatusChart'
        ));
    }
}
