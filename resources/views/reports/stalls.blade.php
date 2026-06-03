@extends('layouts.admin')

@section('title', 'Stalls Report')

@section('content')
<div class="fade-in">
    <h2 class="text-kadaju-gold mb-4"><i class="bi bi-shop me-2"></i>Stalls Report</h2>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr><th>Stall #</th><th>Location</th><th>Size</th><th>Monthly Rent</th><th>Status</th><th>Assignments</th></tr>
                    </thead>
                    <tbody>
                        @forelse($stalls as $stall)
                        <tr>
                            <td>{{ $stall->stall_number }}</td>
                            <td>{{ $stall->location }}</td>
                            <td>{{ $stall->size ?? 'N/A' }}</td>
                            <td>{{ number_format($stall->monthly_rent, 2) }}</td>
                            <td>
                                @if($stall->status === 'available') <span class="badge bg-success">Available</span>
                                @elseif($stall->status === 'occupied') <span class="badge bg-warning text-dark">Occupied</span>
                                @else <span class="badge bg-danger">Maintenance</span> @endif
                            </td>
                            <td>{{ $stall->vendors_count }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No stalls found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
