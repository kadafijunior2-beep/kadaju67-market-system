@extends('layouts.admin')

@section('title', 'Vendor Details')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-kadaju-gold"><i class="bi bi-person-vcard me-2"></i>Vendor Details</h2>
        <div>
            <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-kadaju-outline-gold">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
            <a href="{{ route('vendors.index') }}" class="btn btn-kadaju-outline-gold">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><i class="bi bi-info-circle me-2"></i>Vendor Information</div>
                <div class="card-body">
                    <table class="table table-dark table-borderless">
                        <tr>
                            <td class="text-kadaju-gold">Name:</td>
                            <td>{{ $vendor->full_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-kadaju-gold">Phone:</td>
                            <td>{{ $vendor->phone }}</td>
                        </tr>
                        <tr>
                            <td class="text-kadaju-gold">Email:</td>
                            <td>{{ $vendor->email ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-kadaju-gold">National ID:</td>
                            <td>{{ $vendor->national_id }}</td>
                        </tr>
                        <tr>
                            <td class="text-kadaju-gold">Business Type:</td>
                            <td>{{ ucfirst($vendor->business_type) }}</td>
                        </tr>
                        <tr>
                            <td class="text-kadaju-gold">Reg. Date:</td>
                            <td>{{ $vendor->registration_date->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-kadaju-gold">Status:</td>
                            <td>
                                @if($vendor->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($vendor->status === 'inactive')
                                    <span class="badge bg-warning text-dark">Inactive</span>
                                @else
                                    <span class="badge bg-danger">Suspended</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="bi bi-cash-stack me-2"></i>Recent Payments</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Reference</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vendor->payments as $payment)
                                <tr>
                                    <td>{{ $payment->reference_number }}</td>
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
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No payments recorded</td>
                                </tr>
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
