@extends('layouts.admin')

@section('title', 'Payments')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-kadaju-gold"><i class="bi bi-cash-stack me-2"></i>Payments</h2>
        @can('create', App\Models\Payment::class)
        <a href="{{ route('payments.create') }}" class="btn btn-kadaju-gold"><i class="bi bi-plus-lg me-1"></i> Record Payment</a>
        @endcan
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('payments.index') }}">
                <div class="row g-2">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Search reference or vendor..." value="{{ $filters['search'] ?? '' }}">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="failed" {{ ($filters['status'] ?? '') === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ ($filters['status'] ?? '') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="payment_method" class="form-select">
                            <option value="">All Methods</option>
                            <option value="cash" {{ ($filters['payment_method'] ?? '') === 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank_transfer" {{ ($filters['payment_method'] ?? '') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="mobile_money" {{ ($filters['payment_method'] ?? '') === 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                            <option value="check" {{ ($filters['payment_method'] ?? '') === 'check' ? 'selected' : '' }}>Check</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_from" class="form-control" value="{{ $filters['date_from'] ?? '' }}" placeholder="From">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_to" class="form-control" value="{{ $filters['date_to'] ?? '' }}" placeholder="To">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-kadaju-outline-gold w-100"><i class="bi bi-search"></i></button>
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
                        <tr><th>Ref #</th><th>Vendor</th><th>Amount</th><th>Method</th><th>Date</th><th>Status</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->reference_number }}</td>
                            <td><a href="{{ route('vendors.show', $payment->vendor) }}" class="text-kadaju-gold text-decoration-none">{{ $payment->vendor->full_name ?? 'N/A' }}</a></td>
                            <td>{{ number_format($payment->amount, 2) }}</td>
                            <td>{{ str_replace('_', ' ', ucfirst($payment->payment_method)) }}</td>
                            <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                            <td>
                                @if($payment->status === 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($payment->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($payment->status === 'failed')
                                    <span class="badge bg-danger">Failed</span>
                                @else
                                    <span class="badge bg-secondary">Refunded</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('payments.show', $payment) }}" class="btn btn-outline-info" title="View"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('payments.receipt', $payment) }}" class="btn btn-outline-primary" title="Receipt"><i class="bi bi-receipt"></i></a>
                                    @can('update', $payment)
                                    <a href="{{ route('payments.edit', $payment) }}" class="btn btn-outline-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                    @endcan
                                    @can('delete', $payment)
                                    <button class="btn btn-outline-danger" title="Delete" onclick="confirmDelete({{ $payment->id }})"><i class="bi bi-trash"></i></button>
                                    @endcan
                                </div>
                                @can('delete', $payment)
                                <form id="delete-form-{{ $payment->id }}" action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-none">@csrf @method('DELETE')</form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No payments found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($payments->hasPages())
        <div class="card-footer">{{ $payments->links() }}</div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) { if (confirm('Delete this payment?')) { document.getElementById('delete-form-' + id).submit(); } }
</script>
@endpush
