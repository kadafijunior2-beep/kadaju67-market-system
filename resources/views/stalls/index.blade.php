@extends('layouts.admin')

@section('title', 'Stalls')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-kadaju-gold"><i class="bi bi-shop me-2"></i>Stalls</h2>
        @can('create', App\Models\Stall::class)
        <a href="{{ route('stalls.create') }}" class="btn btn-kadaju-gold">
            <i class="bi bi-plus-lg me-1"></i> Add Stall
        </a>
        @endcan
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('stalls.index') }}">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search by number or location..." value="{{ $filters['search'] ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="available" {{ ($filters['status'] ?? '') === 'available' ? 'selected' : '' }}>Available</option>
                            <option value="occupied" {{ ($filters['status'] ?? '') === 'occupied' ? 'selected' : '' }}>Occupied</option>
                            <option value="maintenance" {{ ($filters['status'] ?? '') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="location" class="form-select">
                            <option value="">All Locations</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc }}" {{ ($filters['location'] ?? '') === $loc ? 'selected' : '' }}>{{ $loc }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-kadaju-outline-gold w-100">
                            <i class="bi bi-search me-1"></i> Filter
                        </button>
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
                        <tr>
                            <th>#</th>
                            <th>Stall Number</th>
                            <th>Location</th>
                            <th>Size</th>
                            <th>Monthly Rent</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stalls as $stall)
                        <tr>
                            <td>{{ $stall->id }}</td>
                            <td><a href="{{ route('stalls.show', $stall) }}" class="text-kadaju-gold text-decoration-none">{{ $stall->stall_number }}</a></td>
                            <td>{{ $stall->location }}</td>
                            <td>{{ $stall->size ?? 'N/A' }}</td>
                            <td>{{ number_format($stall->monthly_rent, 2) }}</td>
                            <td>
                                @if($stall->status === 'available')
                                    <span class="badge bg-success">Available</span>
                                @elseif($stall->status === 'occupied')
                                    <span class="badge bg-warning text-dark">Occupied</span>
                                @else
                                    <span class="badge bg-danger">Maintenance</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('stalls.show', $stall) }}" class="btn btn-outline-info" title="View"><i class="bi bi-eye"></i></a>
                                    @can('update', $stall)
                                    <a href="{{ route('stalls.edit', $stall) }}" class="btn btn-outline-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                    @endcan
                                    @can('delete', $stall)
                                    <button class="btn btn-outline-danger" title="Delete" onclick="confirmDelete({{ $stall->id }}, '{{ $stall->stall_number }}')"><i class="bi bi-trash"></i></button>
                                    @endcan
                                </div>
                                @can('delete', $stall)
                                <form id="delete-form-{{ $stall->id }}" action="{{ route('stalls.destroy', $stall) }}" method="POST" class="d-none">@csrf @method('DELETE')</form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No stalls found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($stalls->hasPages())
        <div class="card-footer">{{ $stalls->links() }}</div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    if (confirm(`Delete stall "${name}"?`)) { document.getElementById('delete-form-' + id).submit(); }
}
</script>
@endpush
