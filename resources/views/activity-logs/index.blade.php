@extends('layouts.admin')

@section('title', 'Activity Logs')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-kadaju-gold"><i class="bi bi-activity me-2"></i>Activity Logs</h2>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('activity-logs.index') }}">
                <div class="row g-2">
                    <div class="col-md-4">
                        <select name="action" class="form-select">
                            <option value="">All Actions</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>{{ ucfirst($action) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
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
                        <tr><th>User</th><th>Action</th><th>Description</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->user?->name ?? 'System' }}</td>
                            <td><span class="badge bg-kadaju-gold text-black">{{ ucfirst($log->action) }}</span></td>
                            <td>{{ $log->description }}</td>
                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">No activity logs found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($logs->hasPages())
        <div class="card-footer">{{ $logs->links() }}</div>
        @endif
    </div>
</div>
@endsection
