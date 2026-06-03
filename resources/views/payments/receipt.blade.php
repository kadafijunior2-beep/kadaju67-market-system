@extends('layouts.admin')

@section('title', 'Payment Receipt')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-kadaju-gold"><i class="bi bi-receipt me-2"></i>Payment Receipt</h2>
        <div>
            <a href="{{ route('payments.print-receipt', $payment) }}" class="btn btn-kadaju-gold"><i class="bi bi-download me-1"></i> Download PDF</a>
            <a href="{{ route('payments.index') }}" class="btn btn-kadaju-outline-gold"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>

    <div class="receipt-container">
        <div class="receipt-header">
            <h2 style="color: #D4AF37; margin: 0;">KADAJU67 MARKET</h2>
            <p style="margin: 5px 0; color: #666;">Vendor Management System</p>
            <h4 style="margin: 15px 0 5px; color: #333;">PAYMENT RECEIPT</h4>
        </div>

        <div class="receipt-details">
            <table>
                <tr><td>Receipt #:</td><td>{{ $payment->reference_number }}</td></tr>
                <tr><td>Date:</td><td>{{ $payment->payment_date->format('d F Y') }}</td></tr>
                <tr><td>Vendor Name:</td><td>{{ $payment->vendor->full_name }}</td></tr>
                <tr><td>Phone:</td><td>{{ $payment->vendor->phone }}</td></tr>
                <tr><td>Business Type:</td><td>{{ ucfirst($payment->vendor->business_type) }}</td></tr>
                <tr><td>Payment Method:</td><td>{{ str_replace('_', ' ', ucfirst($payment->payment_method)) }}</td></tr>
                <tr><td>Status:</td><td>{{ ucfirst($payment->status) }}</td></tr>
                @if($payment->description)
                <tr><td>Description:</td><td>{{ $payment->description }}</td></tr>
                @endif
            </table>

            <div style="margin-top: 30px; border-top: 2px dashed #333; padding-top: 20px; text-align: center;">
                <h3 style="color: #D4AF37; font-size: 24px;">Amount Paid: {{ number_format($payment->amount, 2) }}</h3>
            </div>

            <div style="margin-top: 30px; text-align: center; color: #999; font-size: 12px;">
                <p>This is a computer-generated receipt.</p>
                <p>Kadaju67 Market Vendor Management System</p>
            </div>
        </div>
    </div>
</div>
@endsection
