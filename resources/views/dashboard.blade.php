@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-kadaju-gold"><i class="bi bi-grid-1x2-fill me-2"></i>Dashboard</h2>
        <small class="text-white-50">{{ now()->format('l, d F Y') }}</small>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ $stats['total_vendors'] }}</div>
                        <div class="stat-label">Total Vendors</div>
                    </div>
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                </div>
                <div class="mt-3">
                    <small class="text-success"><i class="bi bi-arrow-up"></i> {{ $stats['active_vendors'] }} active</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ $stats['total_stalls'] }}</div>
                        <div class="stat-label">Total Stalls</div>
                    </div>
                    <div class="stat-icon"><i class="bi bi-shop"></i></div>
                </div>
                <div class="mt-3">
                    <small class="text-warning"><i class="bi bi-building"></i> {{ $stats['occupied_stalls'] }} occupied</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ number_format($stats['total_payments']) }}</div>
                        <div class="stat-label">Total Revenue</div>
                    </div>
                    <div class="stat-icon"><i class="bi bi-cash-stack"></i></div>
                </div>
                <div class="mt-3">
                    <small class="text-info"><i class="bi bi-calendar"></i> All time</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ number_format($stats['monthly_revenue']) }}</div>
                        <div class="stat-label">Monthly Revenue</div>
                    </div>
                    <div class="stat-icon"><i class="bi bi-graph-up-arrow"></i></div>
                </div>
                <div class="mt-3">
                    <small class="text-danger"><i class="bi bi-clock"></i> {{ $stats['pending_payments'] }} pending</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- Monthly Revenue Chart -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-bar-chart-fill me-2"></i>Revenue Trend (Last 6 Months)
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Vendor Status -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-pie-chart-fill me-2"></i>Vendor Status
                </div>
                <div class="card-body">
                    <canvas id="vendorChart" height="200"></canvas>
                    <div class="mt-3 text-center">
                        <span class="badge bg-success me-1">Active: {{ $vendorStatusChart[0] }}</span>
                        <span class="badge bg-warning me-1">Inactive: {{ $vendorStatusChart[1] }}</span>
                        <span class="badge bg-danger">Suspended: {{ $vendorStatusChart[2] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-cash me-2"></i>Recent Payments
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Reference</th>
                                    <th>Vendor</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPayments as $payment)
                                <tr>
                                    <td>{{ $payment->reference_number }}</td>
                                    <td>{{ $payment->vendor->full_name ?? 'N/A' }}</td>
                                    <td>{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No payments yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-activity me-2"></i>Recent Activities
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recentActivities as $log)
                        <div class="list-group-item bg-transparent text-white border-secondary">
                            <div class="d-flex w-100 justify-content-between">
                                <small class="text-kadaju-gold">{{ ucfirst($log->action) }}</small>
                                <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ $log->description }}</p>
                            <small class="text-muted">{{ $log->user?->name ?? 'System' }}</small>
                        </div>
                        @empty
                        <div class="list-group-item bg-transparent text-muted text-center">No activities</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($monthlyRevenue, 'month')) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode(array_column($monthlyRevenue, 'revenue')) !!},
                borderColor: '#D4AF37',
                backgroundColor: 'rgba(212, 175, 55, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { labels: { color: '#fff' } } },
            scales: {
                x: { ticks: { color: '#fff' }, grid: { color: 'rgba(255,255,255,0.1)' } },
                y: { ticks: { color: '#fff' }, grid: { color: 'rgba(255,255,255,0.1)' } }
            }
        }
    });

    new Chart(document.getElementById('vendorChart'), {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Inactive', 'Suspended'],
            datasets: [{
                data: {!! json_encode($vendorStatusChart) !!},
                backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { labels: { color: '#fff' } } }
        }
    });
});
</script>
@endpush
