@extends('layouts.admin')

@section('title', 'Payment Details')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-kadaju-gold"><i class="bi bi-receipt me-2"></i>Payment Details</h2>
        <div>
            <a href="{{ route('payments.receipt', $payment) }}" class="btn btn-kadaju-outline-gold"><i class="bi bi-printer me-1"></i> View Receipt</a>
            <a href="{{ route('payments.index') }}" class="btn btn-kadaju-outline-gold"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><i class="bi bi-info-circle me-2"></i>Payment Information</div>
                <div class="card-body">
                    <table class="table table-dark table-borderless">
                        <tr><td class="text-kadaju-gold">Reference:</td><td>{{ $payment->reference_number }}</td></tr>
                        <tr><td class="text-kadaju-gold">Vendor:</td><td>{{ $payment->vendor->full_name ?? 'N/A' }}</td></tr>
                        <tr><td class="text-kadaju-gold">Amount:</td><td>{{ number_format($payment->amount, 2) }}</td></tr>
                        <tr><td class="text-kadaju-gold">Method:</td><td>{{ str_replace('_', ' ', ucfirst($payment->payment_method)) }}</td></tr>
                        <tr><td class="text-kadaju-gold">Date:</td><td>{{ $payment->payment_date->format('d/m/Y') }}</td></tr>
                        <tr><td class="text-kadaju-gold">Status:</td>
                            <td>
                                @if($payment->status === 'completed') <span class="badge bg-success">Completed</span>
                                @elseif($payment->status === 'pending') <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($payment->status === 'failed') <span class="badge bg-danger">Failed</span>
                                @else <span class="badge bg-secondary">Refunded</span>
                                @endif
                            </td>
                        </tr>
                        @if($payment->description)
                        <tr><td class="text-kadaju-gold">Description:</td><td>{{ $payment->description }}</td></tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
