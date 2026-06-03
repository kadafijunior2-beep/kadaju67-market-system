@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
<div class="fade-in">
    <h2 class="text-kadaju-gold mb-4"><i class="bi bi-file-earmark-bar-graph-fill me-2"></i>Reports</h2>

    <div class="row g-4">
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('reports.vendors') }}" class="text-decoration-none">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="bi bi-people-fill text-kadaju-gold" style="font-size: 3rem;"></i>
                        <h5 class="mt-3 text-white">Vendors Report</h5>
                        <p class="text-white-50 small">View and export vendor information</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('reports.stalls') }}" class="text-decoration-none">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="bi bi-shop text-kadaju-gold" style="font-size: 3rem;"></i>
                        <h5 class="mt-3 text-white">Stalls Report</h5>
                        <p class="text-white-50 small">View stall occupancy details</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('reports.revenue') }}" class="text-decoration-none">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="bi bi-cash-stack text-kadaju-gold" style="font-size: 3rem;"></i>
                        <h5 class="mt-3 text-white">Revenue Report</h5>
                        <p class="text-white-50 small">Track revenue by date range</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('reports.monthly') }}" class="text-decoration-none">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="bi bi-calendar-check text-kadaju-gold" style="font-size: 3rem;"></i>
                        <h5 class="mt-3 text-white">Monthly Report</h5>
                        <p class="text-white-50 small">Annual revenue breakdown</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
