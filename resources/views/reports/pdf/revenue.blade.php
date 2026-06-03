<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Revenue Report</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; padding: 20px; }
        h1 { color: #D4AF37; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #000; color: #D4AF37; padding: 10px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        .total-row { font-weight: bold; background: #f5f5f5; }
        .footer { text-align: center; margin-top: 30px; color: #999; font-size: 12px; }
    </style>
</head>
<body>
    <h1>KADAJU67 MARKET</h1>
    <h3 style="text-align: center;">Revenue Report</h3>
    <p style="text-align: center;">Period: {{ $startDate }} to {{ $endDate }}</p>

    <table>
        <thead>
            <tr><th>Date</th><th>Vendor</th><th>Reference</th><th>Method</th><th>Amount</th></tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                <td>{{ $payment->vendor->full_name ?? 'N/A' }}</td>
                <td>{{ $payment->reference_number }}</td>
                <td>{{ str_replace('_', ' ', ucfirst($payment->payment_method)) }}</td>
                <td>{{ number_format($payment->amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">Total Revenue:</td>
                <td>{{ number_format($total, 2) }}</td>
            </tr>
        </tfoot>
    </table>
    <div class="footer">
        <p>Kadaju67 Market Vendor Management System</p>
    </div>
</body>
</html>
