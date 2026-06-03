@extends('layouts.admin')

@section('title', 'Vendors Report')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-kadaju-gold"><i class="bi bi-people-fill me-2"></i>Vendors Report</h2>
        <a href="{{ route('reports.vendors', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="btn btn-kadaju-gold">
            <i class="bi bi-filetype-pdf me-1"></i> Export PDF
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.vendors') }}">
                <div class="row g-2">
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ ($filters['status'] ?? '') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date_from" class="form-control" value="{{ $filters['date_from'] ?? '' }}" placeholder="From">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date_to" class="form-control" value="{{ $filters['date_to'] ?? '' }}" placeholder="To">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-kadaju-outline-gold w-100"><i class="bi bi-filter me-1"></i> Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr><th>Name</th><th>Phone</th><th>Business Type</th><th>Status</th><th>Payments Count</th><th>Total Paid</th></tr>
                    </thead>
                    <tbody>
                        @forelse($vendors as $vendor)
                        <tr>
                            <td>{{ $vendor->full_name }}</td>
                            <td>{{ $vendor->phone }}</td>
                            <td>{{ ucfirst($vendor->business_type) }}</td>
                            <td>
                                @if($vendor->status === 'active') <span class="badge bg-success">Active</span>
                                @elseif($vendor->status === 'inactive') <span class="badge bg-warning text-dark">Inactive</span>
                                @else <span class="badge bg-danger">Suspended</span> @endif
                            </td>
                            <td>{{ $vendor->payments_count }}</td>
                            <td>{{ number_format($vendor->payments_sum_amount ?? 0, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No vendors found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
