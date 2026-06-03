@extends('layouts.admin')

@section('title', 'Revenue Report')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-kadaju-gold"><i class="bi bi-cash-stack me-2"></i>Revenue Report</h2>
        <a href="{{ route('reports.revenue', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="btn btn-kadaju-gold">
            <i class="bi bi-filetype-pdf me-1"></i> Export PDF
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.revenue') }}">
                <div class="row g-2">
                    <div class="col-md-4">
                        <label class="form-label text-white-50">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-white-50">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-kadaju-outline-gold w-100"><i class="bi bi-filter me-1"></i> Generate</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-value text-kadaju-gold">{{ number_format($report['total'], 2) }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-value">{{ $report['count'] }}</div>
                <div class="stat-label">Total Transactions</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-value">{{ count($report['by_method']) }}</div>
                <div class="stat-label">Payment Methods Used</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="bi bi-list me-2"></i>Transactions</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr><th>Date</th><th>Vendor</th><th>Reference</th><th>Method</th><th>Amount</th></tr>
                    </thead>
                    <tbody>
                        @forelse($report['payments'] as $payment)
                        <tr>
                            <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                            <td>{{ $payment->vendor->full_name ?? 'N/A' }}</td>
                            <td>{{ $payment->reference_number }}</td>
                            <td>{{ str_replace('_', ' ', ucfirst($payment->payment_method)) }}</td>
                            <td>{{ number_format($payment->amount, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No payments found for this period</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
