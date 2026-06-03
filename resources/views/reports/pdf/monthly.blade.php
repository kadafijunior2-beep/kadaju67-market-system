<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Monthly Report</title>
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
    <h3 style="text-align: center;">Monthly Report - {{ $report['year'] }}</h3>

    <table>
        <thead>
            <tr><th>Month</th><th>Transactions</th><th>Revenue</th></tr>
        </thead>
        <tbody>
            @foreach($report['data'] as $item)
            <tr>
                <td>{{ $item['month'] }}</td>
                <td>{{ $item['count'] }}</td>
                <td>{{ number_format($item['revenue'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td>Total</td>
                <td>{{ array_sum(array_column($report['data'], 'count')) }}</td>
                <td>{{ number_format($report['total'], 2) }}</td>
            </tr>
        </tfoot>
    </table>
    <div class="footer">
        <p>Kadaju67 Market Vendor Management System</p>
    </div>
</body>
</html>
