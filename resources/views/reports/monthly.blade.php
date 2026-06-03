@extends('layouts.admin')

@section('title', 'Monthly Report')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-kadaju-gold"><i class="bi bi-calendar-check me-2"></i>Monthly Report - {{ $report['year'] }}</h2>
        <a href="{{ route('reports.monthly', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="btn btn-kadaju-gold">
            <i class="bi bi-filetype-pdf me-1"></i> Export PDF
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-value text-kadaju-gold">{{ number_format($report['total'], 2) }}</div>
                <div class="stat-label">Annual Total</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr><th>Month</th><th>Transactions</th><th>Revenue</th></tr>
                    </thead>
                    <tbody>
                        @foreach($report['data'] as $item)
                        <tr>
                            <td>{{ $item['month'] }}</td>
                            <td>{{ $item['count'] }}</td>
                            <td>{{ number_format($item['revenue'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="text-kadaju-gold fw-bold">
                            <td>Total</td>
                            <td>{{ array_sum(array_column($report['data'], 'count')) }}</td>
                            <td>{{ number_format($report['total'], 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
