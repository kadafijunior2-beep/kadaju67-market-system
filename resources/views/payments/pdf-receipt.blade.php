<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt - {{ $payment->reference_number }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; padding: 30px; }
        .header { text-align: center; border-bottom: 2px dashed #333; padding-bottom: 20px; margin-bottom: 20px; }
        .header h2 { color: #D4AF37; margin: 0; }
        .header p { margin: 5px 0; color: #666; }
        .details table { width: 100%; }
        .details td { padding: 8px; }
        .details td:first-child { font-weight: bold; width: 40%; }
        .amount { text-align: center; margin-top: 30px; border-top: 2px dashed #333; padding-top: 20px; }
        .amount h3 { color: #D4AF37; font-size: 24px; }
        .footer { text-align: center; margin-top: 30px; color: #999; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>KADAJU67 MARKET</h2>
        <p>Vendor Management System</p>
        <h4 style="margin: 15px 0 5px; color: #333;">PAYMENT RECEIPT</h4>
    </div>
    <div class="details">
        <table>
            <tr><td>Receipt #:</td><td>{{ $payment->reference_number }}</td></tr>
            <tr><td>Date:</td><td>{{ $payment->payment_date->format('d F Y') }}</td></tr>
            <tr><td>Vendor:</td><td>{{ $payment->vendor->full_name }}</td></tr>
            <tr><td>Phone:</td><td>{{ $payment->vendor->phone }}</td></tr>
            <tr><td>Business Type:</td><td>{{ ucfirst($payment->vendor->business_type) }}</td></tr>
            <tr><td>Method:</td><td>{{ str_replace('_', ' ', ucfirst($payment->payment_method)) }}</td></tr>
            <tr><td>Status:</td><td>{{ ucfirst($payment->status) }}</td></tr>
            @if($payment->description)
            <tr><td>Description:</td><td>{{ $payment->description }}</td></tr>
            @endif
        </table>
    </div>
    <div class="amount">
        <h3>Amount Paid: {{ number_format($payment->amount, 2) }}</h3>
    </div>
    <div class="footer">
        <p>Computer-generated receipt | Kadaju67 Market</p>
    </div>
</body>
</html>
