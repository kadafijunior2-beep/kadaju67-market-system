@extends('layouts.admin')

@section('title', 'Vendors')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-kadaju-gold"><i class="bi bi-people-fill me-2"></i>Vendors</h2>
        @can('create', App\Models\Vendor::class)
        <a href="{{ route('vendors.create') }}" class="btn btn-kadaju-gold">
            <i class="bi bi-plus-lg me-1"></i> Add Vendor
        </a>
        @endcan
    </div>

    <!-- Search & Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('vendors.index') }}">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search by name, phone, ID..." value="{{ $filters['search'] ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ ($filters['status'] ?? '') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="business_type" class="form-select">
                            <option value="">All Types</option>
                            @foreach($businessTypes as $type)
                                <option value="{{ $type }}" {{ ($filters['business_type'] ?? '') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
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

    <!-- Vendors Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Phone</th>
                            <th>Business Type</th>
                            <th>Reg. Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vendors as $vendor)
                        <tr>
                            <td>{{ $vendor->id }}</td>
                            <td>
                                <a href="{{ route('vendors.show', $vendor) }}" class="text-kadaju-gold text-decoration-none">
                                    {{ $vendor->full_name }}
                                </a>
                            </td>
                            <td>{{ $vendor->phone }}</td>
                            <td>{{ ucfirst($vendor->business_type) }}</td>
                            <td>{{ $vendor->registration_date->format('d/m/Y') }}</td>
                            <td>
                                @if($vendor->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($vendor->status === 'inactive')
                                    <span class="badge bg-warning text-dark">Inactive</span>
                                @else
                                    <span class="badge bg-danger">Suspended</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('vendors.show', $vendor) }}" class="btn btn-outline-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @can('update', $vendor)
                                    <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endcan
                                    @can('delete', $vendor)
                                    <button type="button" class="btn btn-outline-danger" title="Delete"
                                        onclick="confirmDelete({{ $vendor->id }}, '{{ $vendor->full_name }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endcan
                                </div>
                                @can('delete', $vendor)
                                <form id="delete-form-{{ $vendor->id }}" action="{{ route('vendors.destroy', $vendor) }}" method="POST" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No vendors found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($vendors->hasPages())
        <div class="card-footer">
            {{ $vendors->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    if (confirm(`Are you sure you want to delete vendor "${name}"?`)) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
