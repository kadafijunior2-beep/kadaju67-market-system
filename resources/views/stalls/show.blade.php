@extends('layouts.admin')

@section('title', 'Stall Details')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-kadaju-gold"><i class="bi bi-shop me-2"></i>Stall: {{ $stall->stall_number }}</h2>
        <div>
            <a href="{{ route('stalls.edit', $stall) }}" class="btn btn-kadaju-outline-gold"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('stalls.index') }}" class="btn btn-kadaju-outline-gold"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><i class="bi bi-info-circle me-2"></i>Stall Information</div>
                <div class="card-body">
                    <table class="table table-dark table-borderless">
                        <tr><td class="text-kadaju-gold">Number:</td><td>{{ $stall->stall_number }}</td></tr>
                        <tr><td class="text-kadaju-gold">Location:</td><td>{{ $stall->location }}</td></tr>
                        <tr><td class="text-kadaju-gold">Size:</td><td>{{ $stall->size ?? 'N/A' }}</td></tr>
                        <tr><td class="text-kadaju-gold">Monthly Rent:</td><td>{{ number_format($stall->monthly_rent, 2) }}</td></tr>
                        <tr><td class="text-kadaju-gold">Status:</td>
                            <td>
                                @if($stall->status === 'available') <span class="badge bg-success">Available</span>
                                @elseif($stall->status === 'occupied') <span class="badge bg-warning text-dark">Occupied</span>
                                @else <span class="badge bg-danger">Maintenance</span> @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($stall->status !== 'occupied')
            <div class="card mt-3">
                <div class="card-header"><i class="bi bi-person-plus me-2"></i>Assign Vendor</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('stalls.assign-vendor', $stall) }}">
                        @csrf
                        <div class="mb-3">
                            <select name="vendor_id" class="form-select" required>
                                <option value="">Select Vendor</option>
                                @foreach($vendors as $v)
                                    <option value="{{ $v->id }}">{{ $v->full_name }} - {{ $v->phone }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-kadaju-gold w-100"><i class="bi bi-check-lg me-1"></i> Assign</button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="bi bi-clock-history me-2"></i>Assignment History</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0">
                            <thead>
                                <tr><th>Vendor</th><th>Assigned At</th><th>Vacated At</th><th>Status</th></tr>
                            </thead>
                            <tbody>
                                @forelse($stall->vendors as $vendor)
                                <tr>
                                    <td>{{ $vendor->full_name }}</td>
                                    <td>{{ $vendor->pivot->assigned_at }}</td>
                                    <td>{{ $vendor->pivot->vacated_at ?? 'Currently Assigned' }}</td>
                                    <td>
                                        @if($vendor->pivot->is_current)
                                            <span class="badge bg-success">Current</span>
                                        @else
                                            <span class="badge bg-secondary">Past</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted">No assignment history</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
